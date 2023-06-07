<?php
class PostController extends Controller
{
    public function beforeAction($action) {
        header('Content-Type: application/json');

        if (Yii::app()->user->isGuest) {
            throw new CHttpException(403);
        }

        return true;
    }

    public function actionCreate() {
        $body = Yii::app()->request->rawBody;
        $data = CJSON::decode($body);
        $model = new Post();
        $model->title = $data['title'] ?? null;
        $model->content = $data['content'] ?? null;
        $model->status = Post::STATUS_NEW;
        $model->author_id = Yii::app()->user->id;
        $model->created_at = date('Y-m-d H:i:s');

        if (!$model->save()) {
            echo CJSON::encode($model->getErrors());
        } else {
            echo CJSON::encode([
                'id' => $model->id,
                'created_at' => $model->created_at,
            ]);
        }
    }

    public function actionEdit($id) {
        $body = Yii::app()->request->rawBody;
        $data = CJSON::decode($body);
        $model = Post::model()->findByPk($id);
        $model->title = $data['title'] ?? null;
        $model->content = $data['content'] ?? null;
        $model->status = Post::STATUS_EDITED;
        $model->author_id = Yii::app()->user->id;

        if (!$model->save()) {
            echo CJSON::encode($model->getErrors());
        } else {
            echo CJSON::encode([
                'id' => $model->id,
                'status' => $model->status,
                'created_at' => $model->created_at,
            ]);
        }
    }

    public function actionDelete($id) {
        $post = Post::model()->findByPk($id);
        $post->delete();
    }

    public function actionView($id) {
        $post = Post::model()->findByPk($id);
        echo CJSON::encode($post);
    }

    public function actionList() {
        $body = Yii::app()->request->rawBody;
        $data = CJSON::decode($body);

        $sort_field = $data['sort_field'] ?? 'id';
        $sort_order = $data['sort_order'] ?? 'DESC';

        $page_size = (int) ($data['page_size'] ?? 10);
        $page = (int) ($data['page'] ?? 0);

        $availableFields = ['id', 'title', 'created_at', 'content', 'author_id'];
        $fields = $data['columns'] ?? $availableFields;

        foreach ($fields as $field) {
            if (!in_array($field, $availableFields)) {
                throw new CHttpException(400);
            }
        }

        if (!in_array($sort_field, ['id', 'title', 'created_at'])) {
            throw new CHttpException(400);
        }

        if (!in_array($sort_order, ['ASC', 'DESC'])) {
            throw new CHttpException(400);
        }

        $dataProvider = new CActiveDataProvider('Post', array(
            'criteria'=>array(
                'select' => implode(',', $fields),
                'order'=> sprintf('%s %s', $sort_field, $sort_order),
                'condition' => ($data['condition'] ?? ''),
            ),
            'pagination'=>array(
                'pageSize'=>$page_size,
                'currentPage' => $page,
            ),
        ));
        $posts = $dataProvider->getData();

        $resultPosts = [];
        foreach ($posts as $post) {
            $resultPosts[] = $post->getAttributes($fields);
        }

        echo CJSON::encode([
            'posts' => $resultPosts,
            'page_count' => $dataProvider->getPagination()->getPageCount(),
            'page' => $dataProvider->getPagination()->getCurrentPage(),
        ]);
    }
}