<?php
/*
* GETやPOSTの値を受け取り無害化するクラス
*/
class FormSanitize
{
  private $content;
  private $flag;
  private $encoding;

  public function __construct(array|string $content, int $flag, string $encoding = null)
  {
    $this->content = $content;
    $this->flag = $flag;
    $this->encoding = $encoding;
  }

  // 単体要素のサニタイズ
  public function sanitize()
  {
    $sanitize_result = htmlentities($this->content, $this->flag, $this->encoding);
    return $sanitize_result;
  }

  // 配列要素のサニタイズ
  public function sanitize_array()
  {
    foreach ($this->content as $key => $value)
      $sanitize_result[$key] = htmlentities($value, $this->flag, $this->encoding);
    return $sanitize_result;
  }
}
