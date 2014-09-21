<?php
  /* connection with database */
  $SERVER="localhost";
$connect=mysql_connect($SERVER,"The User","I'm so sorry :-)");
if(!$connect){
  echo "Nope";
  die("Databaase connection failed:" . mysql_error());
}
$db_select=mysql_select_db('The DB',$connect);
if((!$db_select)) {
  echo "Nope1";
  die("Database connection failed:" . mysql_error());
}
$con2=mysqli_connect("localhost","The User","I'm so sorry :-)","The DB");
$mail_count_row =  mysqli_fetch_array(mysqli_query($con2,"SELECT * FROM `The Mail Count`"));
$mail_count = $mail_count_row['The Mail Count'];



class messenger{
  var $vars;
  function assign_vars($vars) {
    $this->vars = (empty($this->vars)) ? $vars : $this->vars + $vars;
  }
				
  function mailer($to,$mailtype,$key,$from,$pid) {
    if(empty($from)) $from="from: "."Festember 2014"." <"."Some @ SITE .com".">";
				
    $mail_filepath= "mail.html"; 
    $drop_header = '';

    if(!file_exists($mail_filepath)) {
      echo "NO FILE called $mail_filepath FOUND !";
      exit;
    }

    if(($data = @file_get_contents($mail_filepath)) === false) {
      echo "$mail_filepath FILE READ ERROR !";
      exit;
    }
    
    $body = str_replace ("'", "\'", $data); 

    $body = preg_replace('#\{([a-z0-9\-_]*?)\}#is', "' . ((isset(\$this->vars['\\1'])) ? \$this->vars['\\1'] : '') . '", $body);

    eval("\$body = '$body';");
				
    $match=array();

    if (preg_match('#^(Subject:(.*?))$#m', $body, $match)) {
      $subject = (trim($match[2]) != '') ? trim($match[2]) :  $subject ;
      $drop_header .= '[\r\n]*?' . preg_quote($match[1], '#');
    }
    
    if ($drop_header) {
      $body = trim(preg_replace('#' . $drop_header . '#s', '', $body));
    }
				
    echo $to."\n";

    $filename = $pid.".jpg";
    $file = "/home/mailer/public_html/prticket_generator/output/".$pid.".jpg";
    echo $file;
    $file_size = filesize($file);
    $handle = fopen($file, "r");
    $content = fread($handle, $file_size);
    fclose($handle);
    $content = chunk_split(base64_encode($content));
    $uid = md5(uniqid(time()));

    $separator = md5(time());

    $eol = PHP_EOL;

    $headers = "From: Festember <n o - r e p l y@ SITE .com>" . $eol;
    $headers .= 'Reply-To: SOME @ SITE .com' . "\r\n";
    $headers .= "MIME-Version: 1.0" . $eol;
    $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol . $eol;
    $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
    $headers .= "This is a MIME encoded message." . $eol . $eol;

    $headers .= "--" . $separator . $eol;
    $headers .= "Content-Type: text/html; charset=\"iso-8859-1\"" . $eol . "MIME-Version: 1.0" .$eol;
    $headers .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $headers .= $body . $eol . $eol;

    $headers .= "--" . $separator . $eol . "MIME-Version: 1.0" . $eol;
    $headers .= "Content-Type: image/jpeg; filename=\"" . $filename . "\"" . $eol;
    $headers .= "Content-Transfer-Encoding: base64" . $eol;
    $headers .= "Content-Disposition: attachment" . $eol . $eol;
    $headers .= $content . $eol . $eol;
    $headers .= "--" . $separator . "--";

    return mail($to, $subject="Festember 2014 PR Ticket", "", $headers);
  }
				
}

function mailTesting($uid,$name,$email) {

  if($email=="") return;
  $from = "From: "."Festember 2014"." <n o - r e p l y @ SITE .com> \r\n";
  $from .= 'Reply-To: R A N D @ SITE .com' . "\r\n";
  $messenger = new messenger(false);
  $to=$email;
  $messenger->assign_vars(array('NAME'=>$name));
  $messenger->assign_vars(array('FID'=>$uid));
  if ($messenger->mailer($to,"","",$from,$uid)) echo "done";
}

$query=mysql_query("SELECT * FROM `The Users`");
while($result = mysql_fetch_assoc($query)) {
if($result['user_id']>$mail_count) {
				    mailTesting("{$result['user_id']}","{$result['user_fullname']}","{$result['user_email']}");
				    $mail_count_update = mysqli_fetch_array(mysqli_query($con2,"UPDATE `festember_14_mail_countThe Mail Count`.`mail` SET mail_count = ".$result['user_id']));
				    }
}

?>