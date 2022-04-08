<!DOCTYPE html>
<html lang="en">
<!--begin code mirror -->
<!--下面两个是使用Code Mirror必须引入的-->
<link rel="stylesheet" href="/src/codemirror-5.31.0/lib/codemirror.css" />
<script src="/src/codemirror-5.31.0/lib/codemirror.js"></script>
<!--Java代码高亮必须引入-->
<script src="/src/codemirror-5.31.0/clike.js"></script>
<!--groovy代码高亮-->
<script src="/src/codemirror-5.31.0/mode/groovy/groovy.js"></script>
<!--引入css文件，用以支持主题-->
<link rel="stylesheet" href="/src/codemirror-5.31.0/theme/dracula.css" />

<!--支持代码折叠-->
<link rel="stylesheet" href="/src/codemirror-5.31.0/addon/fold/foldgutter.css" />
<script src="/src/codemirror-5.31.0/addon/fold/foldcode.js"></script>
<script src="/src/codemirror-5.31.0/addon/fold/foldgutter.js"></script>
<script src="/src/codemirror-5.31.0/addon/fold/brace-fold.js"></script>
<script src="/src/codemirror-5.31.0/addon/fold/comment-fold.js"></script>
<!--括号匹配-->
<script src="/src/codemirror-5.31.0/addon/edit/matchbrackets.js"></script>
<!--end Code Mirror -->

<head>
    <meta charset="utf-8" />
    <title>wiki文件管理</title>
</head>

<?php
//配置区
//密码：
$password = 'tk12';
$n = basename($_SERVER['SCRIPT_NAME']);

if ($_COOKIE['filehelper_login_password_123456789'] == md5($password)) {
    $c = $_GET['c'];
    $v = $_GET['v'];
    $a = $_GET['a'];
    $b = $_GET['b'];
    $v1 = './' . $v;
    $va = $v1 . $a;

    echo '<h3>123</h3>';
    if ($c == "del") {
        if (is_file($va) == true) {
            unlink($va);
            echo "成功删除" . $a . "！";
        } else {
            echo "文件已经被删除!";
        }
    }
    if ($c == "up") {
        if ($_FILES["file"]["error"] > 0) {
            echo "上传失败! 错误码：" . $_FILES["file"]["error"] . "<br>";
        } else {
            if (file_exists($v1 . $_FILES["file"]["name"])) {
                echo "文件已经存在。 ";
            } else {
                move_uploaded_file($_FILES["file"]["tmp_name"], $v1 . $_FILES["file"]["name"]);
                echo "上传成功！";
            }
        }
    }
    if ($c == "md") {
        if ($a != "") {
            if (is_dir($va)) {
                echo "文件夹已存在！";
            } else {
                mkdir($va);
                echo '文件夹创建成功！';
            }
        } else {
            echo "文件夹名不能为空！";
        }
    }

    echo '</h3>';

    //ed
    if ($c == "ed") {
        if ($_GET['s'] == "1") {
            $eded = fopen($va, 'w');
            fwrite($eded, $_POST['fs']);
            fclose($eded);
            echo '<h3>保存成功！</h3>';
        } else {
            echo '<a href="' . $n . '?v=' . $v . '">返回</a><br><form action="' . $n . '?v=' . $v . '&a=' . $a . '&c=ed&s=1" method="post" enctype="multipart/form-data">
            <textarea type="text" name="fs" id="ed">' . str_replace('</textarea>', '</ t e xtarea>', file_get_contents($va)) . '</textarea></br>
            <button type="submit">保存</button>
            </form>';
        }
    }


    if ($b == "1") {
    } else {
        echo '<a href="' . $n . '?v=' . dirname($v) . '/">返回</a><br>
            <table><tr>
            <th>名称&emsp;&emsp;&emsp;&emsp;</th>
            <th>类型&emsp;&emsp;&emsp;&emsp;</th>
            <th>大小&emsp;&emsp;&emsp;&emsp;</th>
            <th>操作&emsp;&emsp;&emsp;&emsp;</th>
            </tr>
            ';

        if (is_dir($v1) == true) {
            $fs = scandir($v1);
            $i = 2;
            while ($i <= count($fs) - 1) {
                if ($fs[$i] != $n) {
                    echo "<tr><td>" . $fs[$i] . "</td>";
                    if (is_dir($v1 . $fs[$i]) == true) {
                        echo "<td>文件夹</td>";
                        echo "<td>-</td>";
                        echo '<td><a href=' . $n . '?v=' . $v . $fs[$i] . '/>打开</a></td>';
                    }
                    if (is_file($v1 . $fs[$i]) == true) {
                        echo "<td>文件</td>";
                        echo "<td>" . number_format(filesize($v1 . $fs[$i]) / 1024 / 1024, 4, ".", "") . "MB</td>";
                        if (substr(strrchr($fs[$i], '.'), 1) !== 'php' && substr(strrchr($fs[$i], '.'), 1) !== 'asp' && substr(strrchr($fs[$i], '.'), 1) !== 'aspx' && substr(strrchr($fs[$i], '.'), 1) !== 'do') {
                            echo '<td><a href="' . $v . $fs[$i] . '">下载</a>';
                        } else {
                            echo '<td><a href="' . $v . $fs[$i] . '">打开</a>';
                        }
                        echo '&nbsp;<a href="' . $n . '?c=del&a=' . $fs[$i] . '&v=' . $v . '">删除</a>';
                        $ihzm = substr(strrchr($fs[$i], '.'), 1);
                        if ($ihzm !== 'png' && $ihzm !== 'doc' && $ihzm !== 'docx' && $ihzm !== 'jpg' && $ihzm !== 'gif' && $ihzm !== 'zip' &&  $ihzm !== 'apk' && $ihzm !== 'webp' && $ihzm !== 'ppt' && $ihzm !== 'pptx' && $ihzm !== 'exe' && $ihzm !== 'xls') {
                            echo '&nbsp;<a href="' . $n . '?c=ed&v=' . $v . '&a=' . $fs[$i] . '&b=1">编辑</a>';
                        }
                        echo '</td>';
                    }

                    echo "</tr>";
                }
                $i++;
            }
        }

        echo '</table><hr>
            <form action="' . $n . '?v=' . $v . '&c=up" method="post" enctype="multipart/form-data">
            上传文件：<input type="file" name="file">
            <input type="submit" value="上传">
            </form>
            <form action="' . $n . '" method="get" enctype="multipart/form-data">
            新建文件夹：<input type="text" name="a"><input type="hidden" name="c" value="md"><input type="hidden" name="v" value="' . $v . '">
            <input type="submit" value="新建">
            </form>';
    }
} else {
    if ($_POST['password'] == $password) {
        setcookie("filehelper_login_password_123456789", md5($password), time() + 3600);
        header("location:" . $n);
    } else {
        echo '<form action="' . $n . '" method="post" enctype="multipart/form-data">
        请输入密码<input type="password" name="password">
        <input type="submit" value="登录">
        </form>';
    }
}
?>
<script>
    var editor = CodeMirror.fromTextArea(document.getElementById("ed"), {
        mode: "text/groovy", //实现groovy代码高亮
        mode: "text/x-java", //实现Java代码高亮
        lineNumbers: true, //显示行号
        theme: "dracula", //设置主题
        lineWrapping: true, //代码折叠
        foldGutter: true,
        gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
        matchBrackets: true, //括号匹配
        //readOnly: true,        //只读
    });
    editor.setSize('100%', '400px');     //设置代码框的长宽
</script>
</body>

</html>