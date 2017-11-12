<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mail_model extends CI_Model
{
	public $from = 'Wisdom Tree <it@ikiev.biz>';
	
	public $from_email = 'it@ikiev.biz';
	public $from_name = 'Wisdom Tree';
	
	public function send_letter ($type = 'cimail', $email, $title, $from, $html, $plain_text = '')
	{
		if ($type == 'mail')
		{
			$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
			$headers .= "From: ".$from."\r\n"; 
			
			$html = $this->load->view('/mail/mail_tmp1', array("content" => $html), true);
			
			mail($email, $title, $html, $headers);
			return true;
		}
        elseif ($type == 'cimail') {

            $html = $this->load->view('/mail/mail_tmp1', array("content" => $html), true);

            $this->load->library('email');
            $this->email->from($from);
            $this->email->to($email);
            $this->email->subject($title);
            $this->email->message($html);
            $this->email->send();

            // echo $this->email->print_debugger();
        }
		elseif ($type == 'mandrill')
		{
			//In some controller, far far away
			
			$this->load->config('mandrill');
			$this->load->library('mandrill');
			$mandrill_ready = NULL;

			try {

				$this->mandrill->init( $this->config->item('mandrill_api_key') );
				$mandrill_ready = TRUE;

			} catch(Mandrill_Exception $e) {

				$mandrill_ready = FALSE;
				
			}

			if( $mandrill_ready ) {
				
			
				$html = $this->load->view('/mail/mail_tmp1', array("content" => $html), true);
			
				$to = Array();
				
				$to[] = array('email' => $email);
				
			
				//Send us some email!
				$email = array(
					'html' => $html, 
					'text' => $html,
					'subject' => $title,
					'from_email' => $this->from_email,
					'from_name' => $this->from_name,
					'to' => $to 
					);

				return $this->mandrill->messages_send($email);
			}
		}
		else return false;
	}

    public function info_letter ($user_email, $content)
    {
        return $this->send_letter(
            'cimail',
            $user_email,
            'Новый продукт для оптимизации бизнеса и обучения',
            $this->from,
            $content
        );
    }

	public function registration_letter ($user_email, $pass)
	{
		return $this->send_letter(
							'cimail',
							$user_email, 
							'Добро пожаловать в систему Wisdom 1.0.',
							$this->from,							
							'Вы зарегистрировались в Wisdom 1.0.<br /><br />

							<b>'.$this->text->get('your_email').':</b> '.$user_email.'<br />
							<b>'.$this->text->get('your_pass').':</b> '.$pass.'<br /><br />

<img align="center" alt="" src="http://moow.life/files/moow/img/moow_city1_mail.png" width="690" style="max-width:690px; padding-bottom: 0; display: inline !important; vertical-align: bottom;">
<br /><br />
							'
						);
	}


    public function simple_letter ($user_email, $title, $text)
    {
        return $this->send_letter(
            'cimail',
            $user_email,
            $title,
            $this->from,
            $text
        );
    }

    public function add_money_noty($user_email, $user_contact, $money, $payment_arr = false)
    {

        return $this->send_letter(
            'cimail',
            $user_email,
            "Ваш счет пополнен на Wisdom",
            $this->from,
            "Приветствуем вас, ".' '.$user_contact.' <br /><br />
            Ваш счет пополнен на '.$money.' грн.
            '
        );
    }

    public function add_money_ch_status($user_email, $user_contact, $money, $payment_arr = false)
    {

        return $this->send_letter(
            'cimail',
            $user_email,
            "Статус вашей оплаты на Wisdom изменился.",
            $this->from,
            "Добрый день, ".' '.$user_contact.' <br /><br />
            <br /><br />
            Статус оплаты на сумму '.$money.' грн. имеет статус ...
            '
        );
    }

	
}