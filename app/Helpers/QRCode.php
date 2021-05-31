<?php

namespace App\Helpers;

interface QRCode
{
    public function getData();
    public function getSize();
    public function getLabel();
    public function getMargin();
    public function getFontSize();
}
