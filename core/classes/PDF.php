<?php


namespace core\classes;
use Mpdf\Mpdf;

class PDF
{
    private $pdf;
    private $html;

    private $x; //left
    private $y; //top
    private $largura; //width
    private $altura; //height
    private $alinhamento; //text-align

    private $cor; //font-color
    private $fundo; //background-color

    private $letra_familia; //font-family
    private $letra_tamanho; //font-size
    private $letra_tipo; //font-weight

    private $contorno_caixas;

    public function __construct(string $formato = "A4", string $orientacao = "P", string $modo = "utf-8")
    {
        $this->pdf = new Mpdf([
            "format" => $formato,
            "mode" => $modo,
            "orientation" => $orientacao,
        ]);


        $this->html = "";

        $this->contorno_caixas = false;
    }

    public function set_template($template)
    {
        $this->pdf->SetDocTemplate($template);
    }

    public function reset_html()
    {
        $this->html = "";
    }

    public function apresentar_pdf()
    {
        $this->pdf->WriteHTML($this->html);
        $this->pdf->Output();
    }

    public function posicao($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function dimensao($largura, $altura)
    {
        $this->largura = $largura;
        $this->altura = $altura;
    }

    public function cores($cor_letra = 'white', $cor_fundo = 'white')
    {
        $this->cor = $cor_letra;
        $this->fundo = $cor_fundo;
    }

    public function alinhamento($alinhamento)
    {
        $this->alinhamento = $alinhamento;
    }

    public function set_tamanho($tamanho)
    {
        $this->letra_tamanho = $tamanho;
    }

    public function set_weigth($tipo)
    {
        $this->letra_tipo = $tipo;
    }

    public function familia_letra($tipo) {
        $this->letra_familia = $tipo;
    }


    public function escrever_pdf(string $texto)
    {
        $this->html .= "<div style='";

        //posicionamento e dimensao
        $this->html .= "position: absolute;";
        $this->html .= " left: $this->x" . "px;";
        $this->html .= " top: $this->y" . "px;";
        $this->html .= " width: $this->largura" . "px;";
        $this->html .= " height: $this->altura" . "px;";
        $this->html .= " text-align: $this->alinhamento;";


        //cores
        $this->html .= " color: $this->cor;";
        $this->html .= " background-color: $this->fundo;";

        //letra
        $this->html .= " font-size: $this->letra_tamanho;";
        $this->html .= " font-weight: $this->letra_tipo;";
        $this->html .= " font-family: $this->letra_familia;";

        //contorno
        if($this->contorno_caixas) {
            $this->html .= " box-shadow: inset 0px 0px 0px 1px black;";
        }



        $this->html .= "'>";
        $this->html .= $texto;
        $this->html .= "</div>";


    }

    public function adicionar_texto_pdf(string $texto)
    {
        $this->html .= " " . $texto;
    }

    public function nova_pagina_pdf() {
        $this->html .= "<pagebreak>";
    }


}