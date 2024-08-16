
<?php

class PHP_Email_Form {

    public $to = '';
    public $from_name = '';
    public $from_email = '';
    public $subject = '';
    public $smtp = array();
    public $messages = array();
    public $ajax = false;

    public function add_message($content, $label, $priority = 0) {
        $this->messages[] = array(
            'content' => $content,
            'label' => $label,
            'priority' => $priority
        );
    }

    public function send() {
        $headers = "From: {$this->from_name} <{$this->from_email}>\r\n";
        $headers .= "Reply-To: {$this->from_email}\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        $message_body = '';
        foreach ($this->messages as $message) {
            $message_body .= "<p><strong>{$message['label']}:</strong> {$message['content']}</p>";
        }

        if (!empty($this->smtp)) {
            return $this->send_with_smtp($message_body, $headers);
        } else {
            return mail($this->to, $this->subject, $message_body, $headers);
        }
    }

    private function send_with_smtp($message_body, $headers) {
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = $this->smtp['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $this->smtp['username'];
        $mail->Password = $this->smtp['password'];
        $mail->SMTPSecure = $this->smtp['encryption'];
        $mail->Port = $this->smtp['port'];

        $mail->setFrom($this->from_email, $this->from_name);
        $mail->addAddress($this->to);
        $mail->Subject = $this->subject;
        $mail->Body = $message_body;
        $mail->isHTML(true);

        return $mail->send();
    }
}

?>
