
<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
if (!class_exists('PHPMailer\PHPMailer\Exception')){

    // require_once('PHPMailer_5.2.2/class.phpmailer.php');
require_once '../PHPMailer/src/Exception.php';
require_once '../PHPMailer/src/PHPMailer.php';
require_once '../PHPMailer/src/SMTP.php';
    }else{
        die("HArd");
    }


include_once 'config.php';




function str_to_url($url){

   $url = str_replace("'", "", $url);
   $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
   $url = trim($url, "-");
   $url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
   $url = strtolower($url);
   $url = preg_replace('~[^-a-z0-9_]+~', '', $url);
   
   return $url;
}

function redirect($page){

	header('Location: '.ROOT. '/' . $page);
	die;
}



function old_value($key, $default = ''){
	if(!empty($_POST[$key]))
		return $_POST[$key];

	return $default;
}

function old_checked($key, $default = ''){
	if(!empty($_POST[$key]))
		return " checked ";
	
	return "";
}

function old_select($key, $value, $default = ''){
	if(!empty($_POST[$key]) && $_POST[$key] == $value)
		return " selected ";
	
	if($default == $value)
		return " selected ";
	
	return "";
}

function authenticate($row){
	$_SESSION['USER'] = $row;
}


function logged_in(){
	if(!empty($_SESSION['USER']))
		return true;

	return false;
}

function user($key = ''){
	if(empty($key))
		return $_SESSION['USER'];

	if(!empty($_SESSION['USER'][$key]))
		return $_SESSION['USER'][$key];

	return '';
}

function admin_authenticate($row){
	$_SESSION['ADMIN'] = $row;
}

function admin_logged_in(){
	if(!empty($_SESSION['ADMIN']))
		return true;

	return false;
}
function admin($key = ''){
	if(empty($key))
		return $_SESSION['ADMIN'];

	if(!empty($_SESSION['ADMIN'][$key]))
		return $_SESSION['ADMIN'][$key];

	return '';
}



function dbConnect(string $query, array $data = []){
	$pdo = new PDO('mysql:host=localhost;dbname=p_php_bus_booking;charset=utf8', 'root', '');

	$stm = $pdo->prepare($query);
	$stm->execute($data);

	$result = $stm->fetchAll(PDO::FETCH_ASSOC);
	if(is_array($result) && !empty($result))
	{
		return $result;
	}

	return false;

}

function query_row(string $query, array $data = []){

	$pdo = new PDO('mysql:host=localhost;dbname=p_php_bus_booking;charset=utf8', 'root', '');

	$stm = $pdo->prepare($query);
	$stm->execute($data);

	$result = $stm->fetchAll(PDO::FETCH_ASSOC);
	if(is_array($result) && !empty($result))
	{
		return $result[0];
	}

	return false;

}

function get_image($file){
	$file = $file ?? '';
	if(file_exists($file))
	{
		return ROOT.'/'.$file;
	}

	return ROOT.'/admin_assets/images/no_image.jpg';
}

function add_root_to_images($content){

	preg_match_all("/<img[^>]+/", $content, $matches);

	if(is_array($matches[0]) && count($matches[0]) > 0)
	{
		foreach ($matches[0] as $img) {

			preg_match('/src="[^"]+/', $img, $match);
			$new_img = str_replace('src="', 'src="'.ROOT."/", $img);
			$content = str_replace($img, $new_img, $content);

		}
	}
	return $content;
}

function remove_root_from_content($content){
	
	$content = str_replace(ROOT, "", $content);

	return $content;
}

function alert($msg){
    echo "<script>alert('$msg')</script>";
}

function load($link){
    echo "<script>window.location.href =('$link')</script>";
}

function formatTime($time){
    $time = explode(":", $time);
    if ($time[0] > 12) {
        $string = ($time[0] - 12) . ":" . $time[1] . " PM";
    } else {
        $string = ($time[0]) . ":" . $time[1] . " AM";
    }
    return $string;
}

function formatDate($date){
    return date('d-m-Y', strtotime($date));
}





function printReport($id){
    ob_start();
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=p_php_bus_booking;charset=utf8', 'root', '');

        $stmtBusBooking = $pdo->prepare("SELECT bus_booking.*, users.*
              FROM bus_booking INNER JOIN users ON users.id = bus_booking.user_id
                WHERE bus_booking.id = :id ORDER BY j_type");

        $stmtBusBooking->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtBusBooking->execute();

        if ($stmtBusBooking->rowCount() > 0) {
            $output = "<style>
                .a { width: 5%; }
                .b { width: 15% }
                .c { width: 35%; }
                .d { width: 30%; }
                .e { width: 10%; }
                .f { width: 10%; }
                table { border: 1px solid green; border-collapse: collapse; width: 100%; }
                th { font-weight: bold; }
            </style>";

            $sn = 0;

            while ($row = $stmtBusBooking->fetch(PDO::FETCH_ASSOC)) {
                $date = date("D d, M Y", strtotime($row['date_of_depart']));
                $departure = $row['departure'];
                $destination = $row['destination'];
                $bus_no = $row['bus_no'];
                $sn++;
            
                // Decode seat information from JSON
                $seatJson = $row['seat_booking'];
                $seatArray = json_decode($seatJson, true);
            
                // Prepare seat information HTML
                $seatInfoHTML = '';
                if (is_array($seatArray)) {
                    foreach ($seatArray as $seat) {
                        $seatInfoHTML .= " " . $seat[0] . "/ " . $seat[1] . "/ $" . $seat[2] . '<br>';
                    }
                } else {
                    $seatInfoHTML = "No seat information available";
                }
            
                // Build the table row
                $output .= "<tr>
                    <td class='a'>$sn</td>
                    <td class='b'>" . substr(ucwords(strtolower($row['username'])), 0, 15) . "</td>
                    <td class='c'>{$row['booked_id']}</td>
                    <td class='d'>$seatInfoHTML</td>
                    <td class='e'>" . ucwords(strtolower($row['j_type'])) . "</td>
                    <td class='f'>{$row['no_of_pass']}</td>
                </tr>";
            }
 
            $start = '<table width="100%" border="1">
                <tr><th class="a">SN</th><th class="b">Username</th>
                <th class="c">Booking ID</th>
                <th class="d">Seat No/Class/Price</th>
                <th class="e">Type</th>
                <th class="f">No Of People</th></tr>';
            $end = '</table>';
            $result = $start . $output . $end;

        } else {
            $stmtScheduleBooking = $pdo->prepare("SELECT schedule_booking.*, users.*
              FROM schedule_booking INNER JOIN users ON users.id = schedule_booking.user_id
               WHERE schedule_booking.id = :id ORDER BY schedule_booking.schedule_id");

            $stmtScheduleBooking->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtScheduleBooking->execute();

            if ($stmtScheduleBooking->rowCount() < 1) {
                echo "<script>alert('No Users yet for this schedule!');window.location='admin?page=report'</script>";
                exit;
            }

            $output = "<style>
                .a { width: 5%; }
                .b { width: 25% }
                .c { width: 35%; }
                .d { width: 30%; }
                .e { width: 20%; }
                table { border: 1px solid green; border-collapse: collapse; width: 100%; }
                th { font-weight: bold; }
            </style>";

            $sn = 0;

            while ($row = $stmtScheduleBooking->fetch(PDO::FETCH_ASSOC)) {
                $date = date("D d, M Y", strtotime($row['date']));
                $departure = $row['departure'];
                $destination = $row['destination'];
                $bus_no = $row['bus_no'];
                $sn++;
            
                // Build the table row
                $output .= "<tr>
                    <td class='a'>$sn</td>
                    <td class='b'>" . substr(ucwords(strtolower($row['username'])), 0, 15) . "</td>
                    <td class='c'>{$row['booked_id']}</td>
                    <td class='d'>{$row['price']}</td>
                    <td class='e'>{$row['pass']}</td>
                </tr>";
            }
            
            

            $start = '<table width="100%" border="1">
                <tr><th class="a">SN</th><th class="b">Username</th>
                <th class="c">Booking ID</th>
                <th class="d">Price</th>
                <th class="e">No Of People</th></tr>';
            $end = '</table>';
            $result = $start . $output . $end;
        }

        $file_name = preg_replace('/[^a-z0-9]+/', '-', strtolower('bus_booking')) . ".pdf";

        require_once '../PDF/tcpdf_config_alt.php';

        $tcpdf_include_dirs = array(
            realpath('../PDF/tcpdf.php'),
            '/usr/share/php/tcpdf/tcpdf.php',
            '/usr/share/tcpdf/tcpdf.php',
            '/usr/share/php-tcpdf/tcpdf.php',
            '/var/www/tcpdf/tcpdf.php',
            '/var/www/html/tcpdf/tcpdf.php',
            '/usr/local/apache2/htdocs/tcpdf/tcpdf.php',
        );

        foreach ($tcpdf_include_dirs as $tcpdf_include_path) {
            if (@file_exists($tcpdf_include_path)) {
                require_once $tcpdf_include_path;
                break;
            }
        }

        class MYPDF extends TCPDF
        {
            public function Header()
            {
                $bMargin = $this->getBreakMargin();
                $auto_page_break = $this->AutoPageBreak;
                $this->SetAutoPageBreak(false, 0);
                $img_file = K_PATH_IMAGES . "watermark.jpg";
                $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
                $this->SetAlpha(0.5);
                $this->SetAutoPageBreak($auto_page_break, $bMargin);
                $this->setPageMark();
            }
        }

        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor("Admin");
        $pdf->SetTitle("Bus Bookings " . " Ticket");
        $pdf->SetSubject("Bcms");
        $pdf->SetKeywords("Bus Booking System, Road, Bus, Booking, Project, System, Website, Portal ");

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(PDF_MARGIN_LEFT, 7, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(true, 5);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once dirname(__FILE__) . '/lang/eng.php';
            $pdf->setLanguageArray($l);
        }

        $pdf->setFontSubsetting(true);
        $pdf->SetFont('dejavusans', '', 12, '', true);

        $pdf->AddPage();
        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

        $html = '<h5 style="text-align:center"><img src="../../admin_assets/images/train.png" width="80" height="80"/><br/>ONLINE TICKET RESERVATION SYSTEM<br/> LIST OF BOOKINGS  FOR ' . $date . ' </h5> <div style="text-align:center; font-family:courier;font-weight:bold"><font size="+1">' . $bus_no . ' Bus from ' . $departure . ' to ' . $destination . ' </font></div>' . $result;

        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        $pdf->Output($file_name, 'D');
        @unlink($src);
        ob_end_flush();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}









function sendMail($to, $subject, $msg){ //error_reporting(E_ALL);
    global $title;
    //die("<script>alert('".$_SERVER['PHP_SELF']."')</script>");
    // require 'vendor/autoload.php';
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0; // Enable verbose debug output
        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = "mail@mail.com"; // SMTP username
        $mail->Password = "0000001XYZZ"; // SMTP password
        $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465; // TCP port to connect to
        //Recipients
        $from_name = 'E-TICKET SYSTEM ';
        $mail->setFrom($mail->Username, $from_name);
        $mail->addAddress($to); // Name is optional
        $mail->addReplyTo("example@mail.com", "Name Name");
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        // Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = '<!DOCTYPE html>
    <html lang="en">

    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title>Our Response</title>
      <style type="text/css">
      body {margin: 0; padding: 0; min-width: 100%!important;}
      img {height: auto;}
      .content {width: 100%; max-width: 600px;}
      .header {padding: 40px 30px 20px 30px;}
      .innerpadding {padding: 30px 30px 30px 30px;}
      .borderbottom {border-bottom: 1px solid #f2eeed;}
      .subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}
      .h1, .h2, .bodycopy {color: #153643; font-family: sans-serif;}
      .h1 {font-size: 33px; line-height: 38px; font-weight: bold;}
      .h2 {padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;}
      .bodycopy {font-size: 16px; line-height: 22px;}
      .button {text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;}
      .button a {color: #ffffff; text-decoration: none;}
      .footer {padding: 20px 30px 15px 30px;}
      .footercopy {font-family: sans-serif; font-size: 14px; color: #ffffff;}
      .footercopy a {color: #ffffff; text-decoration: underline;}

      @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
      body[yahoo] .hide {display: none!important;}
      body[yahoo] .buttonwrapper {background-color: transparent!important;}
      body[yahoo] .button {padding: 0px!important;}
      body[yahoo] .button a {background-color: #e05443; padding: 15px 15px 13px!important;}
      body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
      }

      /*@media only screen and (min-device-width: 601px) {
        .content {width: 600px !important;}
        .col425 {width: 425px!important;}
        .col380 {width: 380px!important;}
        }*/

      </style>
    </head>

    <body yahoo bgcolor="#f6f8f1">
    <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>
        <!--[if (gte mso 9)|(IE)]>
          <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
            <tr>
              <td>
        <![endif]-->
        <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td bgcolor="#c7d8a7" class="header">
              <table width="70" align="left" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="70" style="padding: 0 20px 20px 0;">
                    <img class="fix" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQaLaZeHpWXMfJd9YmNyfcugjsjCUiyh_-PpQ&usqp=CAU" width="70" height="90" border="0" alt="" />
                  </td>
                </tr>
              </table>
              <!--[if (gte mso 9)|(IE)]>
                <table width="425" align="left" cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td>
              <![endif]-->
              <table class="col425" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 425px;">
                <tr>
                  <td height="70">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="h2" style="padding: 0 0 0 3px;">
                          E-TICKET SYSTEM
                        </td>
                      </tr>
                      <tr>
                        <td class="h3" style="padding: 5px 0 0 0;">
                          URGENT NOTIFICATION
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
              <!--[if (gte mso 9)|(IE)]>
                    </td>
                  </tr>
              </table>
              <![endif]-->
            </td>
          </tr>
          <tr>
            <td class="innerpadding borderbottom">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="h2">
                   Howdy, How are you doing?
                  </td>
                </tr>
                <tr>
                  <td class="bodycopy">
                    You have an urgent message</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td class="innerpadding borderbottom">
              <table width="115" align="left" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="115" style="padding: 0 20px 20px 0;">
                    <img class="fix" src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/article1.png" width="60" height="60" border="0" alt="" />
                  </td>
                </tr>
              </table>
              <!--[if (gte mso 9)|(IE)]>
                <table width="380" align="left" cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td>
              <![endif]-->
              <table class="col380" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 380px;">
                <tr>
                  <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="bodycopy" align="justify">
                          ' . $msg . '
                        </td>
                      </tr>
                      <tr>
                        <td style="padding: 20px 0 0 0;">
                          <table class="buttonwrapper" bgcolor="#e05443" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td class="button" height="45">
                                <a href="' . $_SERVER["HTTP_HOST"] . '">Visit Us!</a>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
              <!--[if (gte mso 9)|(IE)]>
                    </td>
                  </tr>
              </table>
              <![endif]-->
            </td>
          </tr>

          <tr>
            <td class="innerpadding bodycopy">
            If you would like to reach out to us, talk to us any time via the feedback in your account.<br/>Thank You!
            </td>
          </tr>
          <tr>
            <td class="footer" bgcolor="#44525f">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center" class="footercopy">
                  '.$title.'<br/>

                  </td>
                </tr>
                <tr>
                  <td align="center" style="padding: 20px 0 0 0;">

                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <!--[if (gte mso 9)|(IE)]>
              </td>
            </tr>
        </table>
        <![endif]-->
        </td>
      </tr>
    </table>
    </body>
    </html>

    ';
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
        $mail->AltBody = $msg;

        $mail->send();
        return 1;
    } catch (Exception $e) {
        // var_dump($e);
        // exit;
        // return 0;
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return 0;
    }
    return 0;
}



?>