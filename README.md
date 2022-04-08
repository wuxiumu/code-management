# code-management
简单的线上代码管理工具

## 安装
```
composer require wuqb/laravel-codeview
```

## 基本使用
1. 先发布配置文件在config目录下面
```bash
php artisan vendor:publish
```
2. app.php 添加 providers
```php
Wqb\CodeView\CodeViewProvider::class,
```
3. app.php 添加 aliases
```php
'CodeView' => Wqb\CodeView\Facades\CodeView::class
```
4 开始使用
 
执行
```
php artisan serve --port=8080
```
访问
http://127.0.0.1:8080/codeview