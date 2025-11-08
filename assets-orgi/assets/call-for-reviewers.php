<?php 
    $title = "Call for Reviewers";
    require("header-1.php");
?>

<?php

require('phpmailer/class.phpmailer.php');
require('phpmailer/class.smtp.php');

$mail = new PHPMailer;
$mail->isSMTP();
$mail->CharSet = 'utf-8';
// $mail->SMTPDebug = 2;
$mail->Host = '';
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = '';
$mail->Password = '';

$servername = "localhost";
$database = "u622511098_icaitpr";
$username = "";
$password = "";


// $servername = "localhost";
// $database = "test";
// $username = "root";
// $password = "";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
}

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    if($_POST["name"] != '' AND $_POST["affliation"] != '' AND $_POST["phone"] != '' AND $_POST["email"] != '' AND $_POST["specialization"] != '') {

        $name = $_POST["name"];
        $affliation = $_POST["affliation"];
        $mobile_number = $_POST["phone"];
        $email = $_POST["email"];
        $specialization = $_POST["specialization"];
        $scopus_id = $_POST["scopus"];

        $sql = "INSERT INTO reviewers  VALUES ('$name', '$affliation', '$mobile_number', '$email', '$specialization', '$scopus_id')";
        if (mysqli_query($conn, $sql)) {

            $subject = 'Thank you for your submission | Call for Reviewers | ICAITPR-22 ';
            $toemail = $email; // Your Email Address
            $toname = $name; // Your Name

        
            $mail->SetFrom('contact@icaitpr.org', "ICAITPR");
            $mail->AddReplyTo('contact@icaitpr.org', "ICAITPR");
            $mail->AddAddress( $toemail , $toname );
            $mail->addCC("icaitpr2022.pc@vardhaman.org");
            // $mail->addBCC("");
            $mail->Subject = $subject;

            $mail->isHTML(true);

            $variables = array(
                "{{affliation}}" => $affliation,
                "{{name}}" => $name,
                "{{specialization}}" => $specialization
            );


            // $body = "$name $email $mobile_number $affliation $scopus_id $specialization";
            $body = file_get_contents('web_mail_templates/reviewers_submission/template.html');

            foreach ($variables as $key => $value)
                $body = str_replace($key, $value, $body);

            $mail->MsgHTML( $body );
            $sendEmail = $mail->Send();
        }
        else {
             echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        } 
    } 
} 
mysqli_close($conn);
?>


<style type="text/css">
    /*--------------------------------------------------------------
# reviewers-form
--------------------------------------------------------------*/

.reviewers-form .php-email-form {
  box-shadow: 0 0 30px rgba(214, 215, 216, 0.6);
  padding: 30px;
  border-radius: 4px;
}

.reviewers-form .php-email-form .error-message {
  display: none;
  color: #fff;
  background: #ed3c0d;
  text-align: left;
  padding: 15px;
  font-weight: 600;
}

.reviewers-form .php-email-form .error-message br + br {
  margin-top: 25px;
}

.reviewers-form .php-email-form .sent-message {
  display: none;
  color: #fff;
  background: #18d26e;
  text-align: center;
  padding: 15px;
  font-weight: 600;
}

.reviewers-form .php-email-form .loading {
  display: none;
  background: #fff;
  text-align: center;
  padding: 15px;
}

.reviewers-form .php-email-form .loading:before {
  content: "";
  display: inline-block;
  border-radius: 50%;
  width: 24px;
  height: 24px;
  margin: 0 10px -6px 0;
  border: 3px solid #18d26e;
  border-top-color: #eee;
  -webkit-animation: animate-loading 1s linear infinite;
  animation: animate-loading 1s linear infinite;
}

.reviewers-form .php-email-form .form-group {
  margin-bottom: 25px;
}

.reviewers-form .php-email-form input, .reviewers-form .php-email-form select, .reviewers-form .php-email-form textarea {
  box-shadow: none;
  font-size: 14px;
  border-radius: 4px;
}

.reviewers-form .php-email-form input:focus, .reviewers-form .php-email-form select:focus, .reviewers-form .php-email-form textarea:focus {
  border-color: #111111;
}

.reviewers-form .php-email-form input, select {
  padding: 10px 15px;
}

.reviewers-form .php-email-form textarea {
  padding: 12px 15px;
}

.reviewers-form .php-email-form input[type="submit"] {
  background: #e03a3c;
  border: 0;
  padding: 10px 32px;
  color: #fff;
  transition: 0.4s;
  border-radius: 4px;
}

.reviewers-form .php-email-form input[type="submit"]:hover {
  background: #e35052;
}

@-webkit-keyframes animate-loading {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

@keyframes animate-loading {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

</style>

        <!-- ======= reviewers-form Section ======= -->
    <section id="reviewers-form" class="reviewers-form mt-5">
      <div class="container" data-aos="fade-up">
        <div class="section-header">
          <h2>Call for Reviewers</h2>
        </div>

        <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="100">

          <div class="col-lg-10">
            <form action="" method="post" role="form" class="php-email-form">
              <div class="row">
                <div class="col form-group">
                  <select id="affliation" name="affliation" class="form-control" required>
                    <option selected disabled value="">Affiliation</option>
                    <option value="Dr">Dr</option>
                    <option value="Prof">Prof</option>
                    <option value="Mr">Mr</option>
                    <option value="Ms">Ms</option>
                  </select>
                </div>
                <div class="col form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Full Name" required>
                </div>
              </div>

              <div class="row">
                <div class="col form-group">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Easychair associated Email" required>
                </div>
                <div class="col form-group">
                   <input type="tel" id="phone" name="phone" placeholder="Contact Number ( +91 1234567890 )" class="form-control" required>
                </div>
                <div class="col form-group">
                   <input type="text" id="scopus" name="scopus" placeholder="Scopus ID" class="form-control">
                </div>
              </div>

               <div class="row">
                <div class="col form-group">
                  <select id="specialization" name="specialization" class="form-control" required>
                    <option selected disabled value="">Area of Specialization</option>
                    <option value="Big data,Cloud & AI">Big data,Cloud & AI</option>
                    <option value="Data Analytics">Data Analytics</option>
                    <option value="Evolutionary Computing">Evolutionary Computing</option>
                    <option value="Intelligence through IOT">Intelligence through IOT</option>
                    <option value="Pattern Recognition">Pattern Recognition</option>
                    <option value="Security and AI">Security and AI</option>
                    <option value="Web Intelligence">Web Intelligence</option>
                  </select>
                </div>
              </div>

              <div class="my-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center">
                <input type="submit" name="submit" value="Submit Your Entry">
            </form>
          </div>

        </div>

      </div>
    </section><!-- End reviewers-form Section -->


<?php require("footer.php");?>