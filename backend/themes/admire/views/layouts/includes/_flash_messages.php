<?

use kodi\common\enums\AlertType;
use lavrentiev\widgets\toastr\Notification;
use yii\helpers\ArrayHelper;

/**
 * Partial view file for rendering flash messages.
 *
 * @var \yii\web\View $this Current view instance.
 */

// For every flash message
$flashMessages = Yii::$app->session->getAllFlashes(true);
foreach ($flashMessages as $type => $messages) {
    foreach ($messages as $message) {

        // Choose a title
        $title = Yii::t('backend', 'Notification');
        switch ($type) {
            case AlertType::INFO:
                $title = Yii::t('backend', 'Information');
                break;
            case AlertType::SUCCESS:
                $title = Yii::t('backend', 'Success!');
                break;
            case AlertType::WARNING:
                $title = Yii::t('backend', 'Warning!');
                break;
            case AlertType::ERROR:
                $title = Yii::t('backend', 'Failure!');
                break;
        }

        // Merge with defaults
        $message = ArrayHelper::merge([
            'title' => false,
            'message' => $title,
            'progressBar' => true,
            'closeButton' => true,
        ], $message);

        // Render notification
        echo Notification::widget([
            'type' => $type,
            'title' => $message['title'],
            'message' => $message['message'],
            'options' => [
                'progressBar' => $message['progressBar'],
                'closeButton' => $message['closeButton'],
                'positionClass' => 'toast-top-right',
            ],
        ]);
    }
}