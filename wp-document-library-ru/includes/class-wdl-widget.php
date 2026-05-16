<?php
if (! defined('ABSPATH')) { exit; }
class WDL_Documents_Widget extends WP_Widget {
    public function __construct(){ parent::__construct('wdl_widget','Библиотека документов'); }
    public function widget($args,$instance){ echo $args['before_widget']; if(!empty($instance['title'])) echo $args['before_title'].esc_html($instance['title']).$args['after_title']; echo do_shortcode('[document_library view="'.esc_attr($instance['view']??'compact').'" limit="'.absint($instance['limit']??5).'"]'); echo $args['after_widget']; }
    public function form($instance){ ?><p><label>Заголовок</label><input class="widefat" name="<?php echo esc_attr($this->get_field_name('title'));?>" value="<?php echo esc_attr($instance['title']??'');?>"></p><p><label>Режим</label><select name="<?php echo esc_attr($this->get_field_name('view'));?>"><option value="compact">Компактный</option><option value="cards">Карточки</option><option value="categories">Категории</option></select></p><p><label>Количество</label><input type="number" name="<?php echo esc_attr($this->get_field_name('limit'));?>" value="<?php echo esc_attr($instance['limit']??5);?>"></p><?php }
    public function update($new,$old){ return ['title'=>sanitize_text_field($new['title']??''),'view'=>sanitize_key($new['view']??'compact'),'limit'=>absint($new['limit']??5)]; }
}
class WDL_Widget { public function __construct(){ add_action('widgets_init',function(){ register_widget('WDL_Documents_Widget');}); } }
