<?php
require_once 'Class/UnsplashPhoto.php';

// Директория шаблонов
$loader = new Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new Twig\Environment($loader);

$title = get_field('title') ?: 'Your title here...';
$description = get_field('description');

// Получение данных
$unsplashManager = new UnsplashPhoto();
$photo = $unsplashManager->get_unsplash_photos();
$photost = $unsplashManager->display_photos();

// Рендеринг шаблона twig
echo $twig->render('slider.twig', [
    'title' => $title,
    'description' => $description,
    'phototest' => $photost
]);

