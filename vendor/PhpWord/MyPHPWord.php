<?php
/**
 * Created by PhpStorm.
 * User: shops
 * Date: 2017/3/8
 * Time: 14:31
 */

require_once VENDOR_PATH . 'PhpWord' . DIRECTORY_SEPARATOR . 'PHPWord.php';

Class MyPHPWord{

    private $PHPWord;
    private $section;

    public function __construct()
    {
        $this->PHPWord = new PHPWord();
        $this->section = $this->PHPWord->createSection();

        $this->addStyle();
        $this->addParagraph();
        $this->setTableStyle();
    }

    private function addStyle() {
        $this->PHPWord->addFontStyle('H1', array('bold'=>true, 'italic'=>false, 'size'=>26 ));
        $this->PHPWord->addFontStyle('H2', array('bold'=>true, 'italic'=>false, 'size'=>22 ));
        $this->PHPWord->addFontStyle('H3', array('bold'=>true, 'italic'=>false, 'size'=>20 ));

        $this->PHPWord->addFontStyle('NORMAL', array('bold'=>false, 'italic'=>false, 'size'=>16 ));
    }

    private Function addParagraph() {
        $this->PHPWord->addParagraphStyle('CENTER', array('align'=>'center', 'spaceAfter'=>100));
        $this->PHPWord->addParagraphStyle('RIGHT', array('align'=>'right', 'spaceAfter'=>100));
        $this->PHPWord->addParagraphStyle('LEFT', array('align'=>'left', 'spaceAfter'=>100));
    }

    public function addTextBreak($line) {
        $this->section->addTextBreak($line);
    }

    public function addPageBreak() {
        $this->section->addPageBreak();
    }

    private function setTableStyle() {
        $styleTable = array('borderSize'=>6, 'borderColor'=>'000000', 'cellMargin'=>80);
        $styleFirstRow = array('borderBottomSize'=>18, 'borderBottomColor'=>'0000FF', 'bgColor'=>'66BBFF');

        $this->PHPWord->addTableStyle('table_style', $styleTable, $styleFirstRow);
    }

    public function addTable($table_data) {
        $table = $this->section->addTable('table_style');
        $styleCell = array('align'=>'center');
        $fontStyle = array('bold'=>true, 'align'=>'center');

        foreach ($table_data as $key => $row){
            $table->addRow(500);
            foreach ($row as $key => $cell) {
                $table->addCell(2300, $styleCell)->addText($cell, $fontStyle);
            }
        }
    }

    public function addText($text, $styleFont = null, $styleParagraph = null) {
        $this->section->addText($text, $styleFont, $styleParagraph);
    }

    public function downPHPWord( $name = 'WORD' ) {
        $fileName = $name.date("YmdHis");
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition:attachment;filename=".$fileName.".docx");
        header('Cache-Control: max-age=0');
        $objWriter = PHPWord_IOFactory::createWriter($this->PHPWord, 'Word2007');
        $objWriter->save('php://output');
    }
}