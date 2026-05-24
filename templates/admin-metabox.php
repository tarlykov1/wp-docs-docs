<p><button type="button" class="button" id="wdl-select-file">Выбрать файл</button> <button type="button" class="button" id="wdl-remove-file">Удалить файл</button></p>
<input type="hidden" name="wdl_file_id" id="wdl_file_id" value="<?php echo esc_attr($file_id);?>"><p><input type="url" class="widefat" name="wdl_file_url" id="wdl_file_url" value="<?php echo esc_url($file_url);?>" placeholder="URL файла"></p>
<p><label>Версия</label><input class="widefat" type="text" name="wdl_version" value="<?php echo esc_attr($version);?>"></p>
<p><label>Дата обновления</label><input class="widefat" type="date" name="wdl_updated_date" value="<?php echo esc_attr($updated_date);?>"></p>
<p><label>Ответственный</label><input class="widefat" type="text" name="wdl_owner" value="<?php echo esc_attr($owner);?>"></p>
<p><label>Номер документа</label><input class="widefat" type="text" name="wdl_doc_number" value="<?php echo esc_attr($doc_number);?>"></p>
<p><label>Срок действия</label><input class="widefat" type="date" name="wdl_expiry_date" value="<?php echo esc_attr($expiry_date);?>"></p>
<p><label>Краткое описание</label><textarea class="widefat" name="wdl_card_description"><?php echo esc_textarea($card_description);?></textarea></p>
<p><label>Категория документа</label>
<?php if (! empty($document_categories) && ! is_wp_error($document_categories)) : ?>
<select class="widefat" name="wdl_document_category">
    <option value="0">Без категории</option>
    <?php foreach ($document_categories as $document_category) : ?>
        <option value="<?php echo esc_attr($document_category->term_id); ?>" <?php selected(in_array((int) $document_category->term_id, (array) $selected_categories, true)); ?>><?php echo esc_html($document_category->name); ?></option>
    <?php endforeach; ?>
</select>
<?php else : ?>
    <span>Категории документов пока не созданы.</span>
    <a href="<?php echo esc_url(admin_url('edit-tags.php?taxonomy=wdl_document_category&post_type=wdl_document')); ?>">Создать категорию</a>
<?php endif; ?>
</p>
<p><label><input type="checkbox" name="wdl_pdf_viewer" <?php checked($pdf_viewer,1);?>> Показывать PDF через просмотровщик</label></p>
<p><label><input type="checkbox" name="wdl_show_download" <?php checked($show_download,1);?>> Показывать кнопку «Скачать»</label></p>
<p><label><input type="checkbox" name="wdl_important" <?php checked($important,1);?>> Важный</label> <label><input type="checkbox" name="wdl_new" <?php checked($new,1);?>> Новый</label></p>
<p><label>Ручной порядок</label><input type="number" name="wdl_manual_order" value="<?php echo esc_attr($manual_order);?>"></p>
