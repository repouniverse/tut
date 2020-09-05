<?php
use yii\helpers\Html;

      ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
       <title>Zoom WebSDK</title>
    <meta charset="utf-8" />
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.7.5/css/bootstrap.css"/>
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.7.5/css/react-select.css"/>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <?php $this->head() ?>
    </head>
   <body>
       
 <?php $this->beginBody() ?> 
       
<nav id="nav-tool" class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">MyMeetingApp</a>
        </div>
        <div id="navbar">
            <form class="navbar-form navbar-right" id="meeting_form">
                <div class="form-group">
                    <input type="text" name="display_name" id="display_name" value="WebSDK1.7.5#CDN" placeholder="Name" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="text" name="meeting_number" id="meeting_number" value="" placeholder="Meeting Number" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="text" name="meeting_pwd" id="meeting_pwd" value="" placeholder="Meeting Password" class="form-control">
                </div>
          
                <div class="form-group">
                    <select id="meeting_role" class="selectpicker">
                        <option value=0>Attendee</option>
                        <option value=1>Host</option>
                        <option value=5>Assistant</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary" id="join_meeting">Join</button>
            </form>
        </div><!--/.navbar-collapse -->
    </div>
</nav>


<script src="https://source.zoom.us/1.7.5/lib/vendor/react.min.js"></script>
<script src="https://source.zoom.us/1.7.5/lib/vendor/react-dom.min.js"></script>
<script src="https://source.zoom.us/1.7.5/lib/vendor/redux.min.js"></script>
<script src="https://source.zoom.us/1.7.5/lib/vendor/redux-thunk.min.js"></script>
<script src="https://source.zoom.us/1.7.5/lib/vendor/jquery.min.js"></script>
<script src="https://source.zoom.us/1.7.5/lib/vendor/lodash.min.js"></script>

<script src="https://source.zoom.us/zoom-meeting-1.7.5.min.js"></script>
<script src="js/tool.js"></script>
<script src="js/index.js"></script>

<script>
   
</script>
       
        <?= $content ?>

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>



