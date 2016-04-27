<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$lang_plugin_onlinestats['description'] = 'オンライン状態のユーザおよびゲストを表示するためのブロックをギャラリーページに表示します。';
$lang_plugin_onlinestats['name'] = 'Who is online? (誰がオンライン中ですか?)';
$lang_plugin_onlinestats['config_extra'] = 'このプラグインを有効にする (実際にオンライン統計ブロックを表示する) には、<a href="admin.php">Coppermine設定</a>の「アルバムリストビュー」内にある、「メインページのコンテンツ」にストリング「onlinestats」(スラッシュ区切り) を追加する必要があります。追加後の設定は、「breadcrumb/catlist/alblist/onlinestats」または似たような内容になります。ブロックのポジションを変更するには、設定フィールド内のストリング「onlinestats」位置を移動してください。';
$lang_plugin_onlinestats['config_install'] = 'このプラグインが実行されるたび、追加的なクエリがデータベース上で実行されます。このことにより、CPU処理能力に負担をかけ、さらにリソースを使用することになります。あなたのCoppermineギャラリーが遅い、または膨大な数のユーザを登録している場合、このプラグインをインストールすべきではありません。';
$lang_plugin_onlinestats['we_have_reg_member'] = '登録ユーザ数: %s';
$lang_plugin_onlinestats['we_have_reg_members'] = '登録ユーザ数: %s';
$lang_plugin_onlinestats['most_recent'] = '最新登録ユーザ: %s';
$lang_plugin_onlinestats['is'] = '合計オンラインビジター数: %s';
$lang_plugin_onlinestats['are'] = '合計オンラインビジター数: %s';
$lang_plugin_onlinestats['and'] = ' ＆ ';
$lang_plugin_onlinestats['reg_member'] = '%s 登録ユーザ';
$lang_plugin_onlinestats['reg_members'] = '%s 登録ユーザ';
$lang_plugin_onlinestats['guest'] = '%s ゲスト';
$lang_plugin_onlinestats['guests'] = '%s ゲスト';
$lang_plugin_onlinestats['record'] = '最大オンラインユーザ数: %s - %s';
$lang_plugin_onlinestats['since'] = '過去 %s 分のオンラインユーザ数: %s';
$lang_plugin_onlinestats['config_text'] = 'ユーザがページ閲覧を終了したとみなされるまで、どのくらいの時間、ユーザをオンライン一覧に表示しますか?';
$lang_plugin_onlinestats['minute'] = '分';
$lang_plugin_onlinestats['remove'] = 'オンラインデータを保存するため使用されたテーブルを削除しますか?';
