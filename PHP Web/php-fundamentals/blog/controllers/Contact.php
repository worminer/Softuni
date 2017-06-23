<?php

namespace Controllers;


use MVC\DefaultController;


class Contact extends DefaultController
{
//    public function about()
//    {
//        $this->view->render("user/contact");
//    }
    public function show()
    {
        $this->view->render("contact/show");
    }

    public function message()
    {
        $input = [];
        $input['name'] = $this->input->get(0);
        $this->view->render("contact/sendingMessage", $input);
    }

    public function sendingMessage()
    {
        $senderName = $this->input->post('senderName');
        $senderEmail = $this->input->post('email');
        $message = $this->input->post('message');
        $msgTo = $this->input->post('msgTo');

        $developers = [
                        "Raychev"=>"gru@mail.bg",
                        "Ivanka"=>"wanias@abv.bg",
                        "Martin"=>"worminer@gmail.com",
                        "Dimitar" => "dimitar.s@mail.bg",
                        "Villy" => "villyjord@yahoo.com",
                        "Stefan" => "stefan_karadjov@mail.bg"
                    ];
        if (!array_key_exists($msgTo, $developers))
        {
            $msgTo = "";
        }

        if (empty($senderName) || empty($senderEmail) || empty($message) || empty($msgTo))
        {
            $msg = [
                'panel'=>"Invalid input <br>or empty field(s)",
                'button'=>'Go back'
            ];
            $this->view->render("contact/invalidInput", $msg);
        }

        $subject = "DarbyBlog-message from ".$senderName. " |".$senderEmail."|";
        $hasSent = mail($developers[$msgTo], $subject, $message, "Content-Type:text/html;charset=utf-8");

            /*
             *
             */
        if ($hasSent)
        {
            $msg = [

                'panelColor' =>'panel-success',
                'panel'=>"Тhe message was successfully sent",
                'button'=>'Ok'
            ];
        }
        else {
            $msg = [
                'panelColor' => 'panel-danger',
                'panel'=>"The message has not been sent",
                'button'=>'Try again'
            ];
        }

        $this->view->render("contact/sent", $msg);
    }
}











