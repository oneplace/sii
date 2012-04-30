Welcome to AppRunes Developer Center!

To activate your account, simply click on the link below or paste into the url field on your favorite browser:

<?php echo $this->createAbsoluteUrl('site/verify',array('id'=>$user->id,'code'=>$user->verifyKey)) ?>