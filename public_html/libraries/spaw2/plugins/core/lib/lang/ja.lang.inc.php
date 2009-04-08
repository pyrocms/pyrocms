<?php 
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Japanese file
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Japanese Translation: DigiPower <http://pwr.jp/>
// Copyright: Solmetra (c)2003 All rights reserved.
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.1.0, 2003-03-20
// ================================================

// charset to be used in dialogs
$spaw_lang_charset = 'utf-8';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'cut' => array(
    'title' => '切り取り'
  ),
  'copy' => array(
    'title' => 'コピー'
  ),
  'paste' => array(
    'title' => '貼り付け'
  ),
  'undo' => array(
    'title' => '元に戻す'
  ),
  'redo' => array(
    'title' => 'やり直す'
  ),
  'hyperlink' => array(
    'title' => 'ハイパーリンク'
  ),
  'image_insert' => array(
    'title' => 'イメージの挿入',
    'select' => ' 選択する ',
    'cancel' => 'キャンセル',
    'library' => 'ライブラリ',
    'preview' => 'プレビュー',
    'images' => 'イメージ',
    'upload' => 'アップロード',
    'upload_button' => 'アップロード',
    'error' => 'エラー',
    'error_no_image' => 'イメージを指定して下さい',
    'error_uploading' => 'アップロード中にエラーが起こりました。少ししてからもう一度実行してみてください。',
    'error_wrong_type' => 'イメージファイルではありません',
    'error_no_dir' => 'ライブラリが見つかりません',
  ),
  'image_prop' => array(
    'title' => 'イメージのプロパティ',
    'ok' => '    OK    ',
    'cancel' => 'キャンセル',
    'source' => '参照先',
    'alt' => '代替テキスト',
    'align' => '行揃え',
    'justifyleft' => '左',
    'justifyright' => '右',
    'top' => '上',
    'middle' => '中央',
    'bottom' => '下',
    'absmiddle' => '中央(絶対的)',
    'texttop' => '上(絶対的)',
    'baseline' => 'ベースライン',
    'width' => '幅',
    'height' => '高さ',
    'border' => 'ボーダー',
    'hspace' => '横間隔',
    'vspace' => '縦間隔',
    'error' => 'エラー',
    'error_width_nan' => '幅を入力して下さい',
    'error_height_nan' => '高さを入力して下さい',
    'error_border_nan' => 'ボーダーを入力して下さい',
    'error_hspace_nan' => '横間隔を入力して下さい',
    'error_vspace_nan' => '縦間隔を入力して下さい',
  ),
  'inserthorizontalrule' => array(
    'title' => '区切り線'
  ),
  'table_create' => array(
    'title' => 'テーブルの作成'
  ),
  'table_prop' => array(
    'title' => 'テーブルのプロパティ',
    'ok' => '    OK    ',
    'cancel' => 'キャンセル',
    'rows' => '行',
    'columns' => '列',
    'width' => '幅',
    'height' => '高さ',
    'border' => 'ボーダー',
    'pixels' => 'ピクセル',
    'cellpadding' => 'セル内余白',
    'cellspacing' => 'セル内間隔',
    'bg_color' => '背景色',
    'error' => 'エラー',
    'error_rows_nan' => '行を入力して下さい',
    'error_columns_nan' => '列を入力して下さい',
    'error_width_nan' => '幅を入力して下さい',
    'error_height_nan' => '高さを入力して下さい',
    'error_border_nan' => 'ボーダーを入力して下さい',
    'error_cellpadding_nan' => 'セル内余白を入力して下さい',
    'error_cellspacing_nan' => 'セル内間隔を入力して下さい',
  ),
  'table_cell_prop' => array(
    'title' => 'セルのプロパティ',
    'horizontal_align' => '横揃え',
    'vertical_align' => '縦揃え',
    'width' => '幅',
    'height' => '高さ',
    'css_class' => 'CSS クラス',
    'no_wrap' => '折り返さない',
    'bg_color' => '背景色',
    'ok' => '    OK    ',
    'cancel' => 'キャンセル',
    'justifyleft' => '左',
    'justifycenter' => '中央',
    'justifyright' => '右',
    'top' => '上',
    'middle' => '中央',
    'bottom' => '下',
    'baseline' => 'ベースライン',
    'error' => 'エラー',
    'error_width_nan' => '幅を入力して下さい',
    'error_height_nan' => '高さを入力して下さい',
  ),
  'table_row_insert' => array(
    'title' => '行の挿入'
  ),
  'table_column_insert' => array(
    'title' => '列の挿入'
  ),
  'table_row_delete' => array(
    'title' => '行の削除'
  ),
  'table_column_delete' => array(
    'title' => '列の削除'
  ),
  'table_cell_merge_right' => array(
    'title' => '右の列と結合'
  ),
  'table_cell_merge_down' => array(
    'title' => '下の行と結合'
  ),
  'table_cell_split_horizontal' => array(
    'title' => '行を分割'
  ),
  'table_cell_split_vertical' => array(
    'title' => '列を分割'
  ),
  'style' => array(
    'title' => 'スタイル'
  ),
  'fontname' => array(
    'title' => 'フォント'
  ),
  'fontsize' => array(
    'title' => 'サイズ'
  ),
  'formatBlock' => array(
    'title' => '段落'
  ),
  'bold' => array(
    'title' => '太字'
  ),
  'italic' => array(
    'title' => '斜体'
  ),
  'underline' => array(
    'title' => '下線'
  ),
  'insertorderedlist' => array(
    'title' => '番号リスト'
  ),
  'insertunorderedlist' => array(
    'title' => 'リスト'
  ),
  'indent' => array(
    'title' => 'インデント追加'
  ),
  'outdent' => array(
    'title' => 'インデント削除'
  ),
  'justifyleft' => array(
    'title' => '左揃え'
  ),
  'justifycenter' => array(
    'title' => '中央揃え'
  ),
  'justifyright' => array(
    'title' => '右揃え'
  ),
  'fore_color' => array(
    'title' => '文字色'
  ),
  'bg_color' => array(
    'title' => '背景色'
  ),
  'design' => array(
    'title' => 'WYSIWYG (デザイン) モードへ'
  ),
  'html' => array(
    'title' => 'HTML (コード) モードへ'
  ),
  'colorpicker' => array(
    'title' => 'Color picker',
    'ok' => '    OK   ',
    'cancel' => 'キャンセル',
  ),
  'cleanup' => array(
    'title' => 'HTMLクリーンアップ (スタイルの削除)',
    'confirm' => '実行すると、すべてのスタイルやフォントや重複したタグを除去します。場合によってはあなたの意図しない結果になることもありますのでお気を付け下さい。',
    'ok' => '    OK    ',
    'cancel' => 'キャンセル',
  ),
  'toggle_borders' => array(
    'title' => 'ボーダーの切り替え',
  ),
  'hyperlink' => array(
    'title' => 'ハイパーリンク',
    'url' => 'URL',
    'name' => 'サイト名',
    'target' => 'ターゲット',
    'title_attr' => 'タイトル',
    'ok' => '    OK    ',
    'cancel' => 'キャンセル',
  ),
  'table_row_prop' => array(
    'title' => '行のプロパティ',
    'horizontal_align' => '横揃え',
    'vertical_align' => '縦揃え',
    'css_class' => 'CSS クラス',
    'no_wrap' => '折り返さない',
    'bg_color' => '背景色',
    'ok' => '    OK    ',
    'cancel' => 'キャンセル',
    'justifyleft' => '左',
    'justifycenter' => '中央',
    'justifyright' => '右',
    'top' => '上',
    'middle' => '中央',
    'bottom' => '下',
    'baseline' => 'ベースライン',
  ),
  'symbols' => array(
    'title' => '特殊文字',
    'ok' => '    OK    ',
    'cancel' => 'キャンセル',
  ),
  'templates' => array(
    'title' => 'テンプレート',
  ),
  'page_prop' => array(
    'title' => 'ページのプロパティ',
    'title_tag' => 'タイトル',
    'charset' => '文字コード',
    'background' => '背景イメージ',
    'bgcolor' => '背景色',
    'text' => '文字色',
    'link' => 'リンク色',
    'vlink' => '訪問済みリンク色',
    'alink' => 'アクティブリンク色',
    'leftmargin' => '左マージン',
    'topmargin' => '上マージン',
    'css_class' => 'CSS クラス',
    'ok' => '    OK    ',
    'cancel' => 'キャンセル',
  ),
  'preview' => array(
    'title' => 'プレビュー',
  ),
  'image_popup' => array(
    'title' => 'イメージのポップアップ',
  ),
  'zoom' => array(
    'title' => '拡大',
  ),
);
?>

