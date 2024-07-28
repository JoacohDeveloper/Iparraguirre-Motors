<?php


namespace Models;

class Mail
{

    public $fromAddres;
    public $fromName;

    public $toAddres;

    public $subject;

    public $content;

    public $category;


    public function __construct($fromAddres, $fromName, $toAddres, $subject, $content, $category)
    {
        $this->fromAddres = $fromAddres;
        $this->fromName = $fromName;
        $this->toAddres = $toAddres;
        $this->subject = $subject;
        $this->content = $content;
        $this->category = $category;
    }


    public function send()
    {


        $mailtrapURL = $_ENV['MAILTRAP_API_URL'] ?? "";
        $mailtrapPASS = $_ENV['MAILTRAP_PASSWORD'] ?? "";



        $ch = curl_init($mailtrapURL);



        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $mailtrapPASS",
            'Content-Type: application/json'
        ]);




        $data = [
            "from" => [
                "email" => $this->fromAddres,
                "name" => $this->fromName
            ],
            "to" => [["email" => $this->toAddres]],
            "subject" => $this->subject,
            "text" => $this->content,
            "html" => $this->content,
            "category" => $this->category
        ];


        $raw = json_encode($data);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $raw);

        $res = curl_exec($ch);

        curl_close($ch);

        return $res;
    }
}
