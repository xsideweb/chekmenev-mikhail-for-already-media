<?php
class UnsplashPhoto {

    private $keyword;
    private $slides_number;
    private $orientation;
    private $photos; // тут будут храниться фото

    public function __construct() {
        $this->keyword = get_field('keyword');
        $this->slides_number = get_field('slides_number');
        $this->orientation = get_field('ориентация');
        $this->photos = []; // пустой массив для хранения
    }

    public function get_unsplash_photos() {
        $page = 1;
        //подключаем кэширование и
        $transient_key = 'unsplash_photos_' . md5($this->keyword . $page . $this->slides_number . $this->orientation);

        $cached_photos = get_transient($transient_key);
        
        //делаем запрос к Unsplash и проверяем закэшированы ли фото
        if ($cached_photos === false) {
            $result = Unsplash\Search::photos($this->keyword, $page, $this->slides_number, $this->orientation);
            $photos = $result->getResults();
            
            //устанавливаем время кэша 12 часов
            set_transient($transient_key, $photos, 12 * HOUR_IN_SECONDS);

            $this->photos = $photos;
        } else {
            $this->photos = $cached_photos;
        }

        $this->display_photos(); 
    }

    public function display_photos() {
        $photos_data = []; 
        if (!empty($this->photos)) {
            foreach ($this->photos as $photo) {
                $photo_full = $photo['urls']['full'];
                // добавляем данные каждого фото в массив
                $photos_data[] = [
                    'src' => htmlspecialchars($photo_full)
                ];
            }
        }
        return($photos_data); // возвращаем массив с данными фотографий
        
    }
}

?>