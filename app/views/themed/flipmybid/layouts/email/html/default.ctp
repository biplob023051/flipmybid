<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo $title_for_layout;?></title>
    </head>
    <body>

    </body>
</html>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $title_for_layout;?></title>
</head>

<style>

td p{
}

h1{
	color: #BF2F29;
	font-size: 14px;
	font-family: Georgia, "Times New Roman", Times, serif;
}

h2{
	font-size: 12px;
}

h3{
    color: #FFFFFF;
    font-family: "Myriad Pro",Myriad,"Liberation Sans","Nimbus Sans L","Helvetica Neue",Helvetica,Arial,sans-serif;
    font-size: 20px;
	font-weight: 500;
	padding: 0;
	margin: 0;
	padding-left: 90px;
	padding-top: 5px;
	-webkit-margin-before: 0;
	-webkit-margin-after: 0;

}

a{
	color: #08AFD8;
}

</style>

<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" bgcolor="#FFFFFF">

<table width="100%" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size: 12px; color:#3b190b; line-height: 18px;">
  <tr>
    <td align="center">
			<table width="770" cellpadding="0" cellspacing="0" style="border: solid 1px #242424;" >
				<tr>
					<td style="padding-left: 10px; background: #EAEAEA; height: 83px; padding-top: 10px;" align="right" valign="top">
                    	<img src="<?php echo $appConfigurations['url']; ?>/theme/flipmybid/img/newsletter/logo.png" alt="" border="0" style="margin-top: 5px; margin-right: 20px; float: left;">
                        <p style="float: right; margin-right: 10px; color: #242424 ; font-weight: bold; font-family: Verdana, Geneva, sans-serif">Date: <?php echo date('j M Y'); ?></p>
                    </td>
				</tr>
				<tr style="paddding: 10px;">
                	<td style="text-align: center;">
                    	<table style="width: 770px; margin: auto; margin-top: 0px;" cellpadding="0" cellspacing="0">
		                    <tr>
                            	<td style="background:#2D2D2D; font-size: 15px; padding: 8px 10px; color: #08AFD8; font-weight: bold; font-family: 'BebasNeueRegular',Arial,sans-serif; letter-spacing:0; font-size:18px; width: 560px;" align="left">
                            		<?php if(!empty($data['subject'])) : ?>
	                            		<?php echo strtoupper($data['subject']); ?>
	                            	<?php else : ?>
	                            		<?php echo strtoupper($appConfigurations['name'].' Mailer'); ?>
	                            	<?php endif; ?>
                            	</td>
                            </tr>
                            <tr>
                            	<td style="color: #444444; padding: 10px; background:url(<?php echo $appConfigurations['url']; ?>/theme/flipmybid/img/newsletter/bg-body.png);" align="left">
                                	<?php echo $content_for_layout;?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                	<td style="background:#EAEAEA repeat-x; height: 45px; color: #444444; padding-left: 10px; padding-top: 5px;">
                    	<p style="float: left; width: 400px;">Copyright © <?php echo date('Y'); ?>. All rights reserved. </p>
                    </td>
                </tr>
            </table>
  	</td>
  </tr>
</table>

</body>
</html>
