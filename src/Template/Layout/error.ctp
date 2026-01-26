<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->fetch('title') ?> | Error</title>
    <?= $this->Html->meta('icon') ?>
    
    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #container {
            max-width: 600px;
            width: 90%;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        #header {
            background-color: #dc3545;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        #header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        #content {
            padding: 20px;
        }

        #content p {
            margin: 15px 0;
            line-height: 1.6;
        }

        .flash-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        #footer {
            padding: 15px;
            text-align: center;
            background-color: #f1f1f1;
        }

        #footer a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        #footer a:hover {
            text-decoration: underline;
        }
    </style>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body>
    <div id="container">
        <div id="header">
            <h1><?= __('Oops! Something went wrong.') ?></h1>
        </div>
        <div id="content">
            <?= $this->Flash->render('flash', ['element' => 'flash_message']) ?>
            <?= $this->fetch('content') ?>
            <p>If you think this is a mistake, please contact support or try again later.</p>
        </div>
        <div id="footer">
            <?= $this->Html->link(__('Go Back'), 'javascript:history.back()', ['class' => 'btn-back']) ?>
        </div>
    </div>
</body>

</html>
