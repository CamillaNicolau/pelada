<?php

/**
 * To change this license header, choose License Headers in Project Properties.
 *
 * @author Camilla Nicolau
 * @version 1.0
 * @copyright 2018
 */

class Peladeiro { 
    /**
     * Qual posição o usuário joga.
     *
     * @var string
     */
    protected $posicao;
    
    /**
     * Qual o time que o usuario.
     *
     * @var string
     */
    protected $timeFutebol;
    
      /**
     * Define o time
     *
     * @param Time $Time
     * @return void
     */
    public function setTime(Time $Time)
    {
        $this->timeFutebol = $Time->idTime;
    }

    /**
     * Requisita o time
     *
     * @return Time
     */
    public function getTime()
    {
        return new Time($this->timeFutebol);
    }
   /**
     * Define a posicao
     *
     * @param Posicao $Posicao
     * @return void
     */
    public function setPosicao(Posicao $Posicao)
    {
        $this->posicao = $Posicao->idPosicao;
    }

    /**
     * Requisita a posicao
     *
     * @return Time
     */
    public function getPosicao()
    {
        return new Posicao($this->posicao);
    }
}

