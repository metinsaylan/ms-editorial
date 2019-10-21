<?php 

global $editorial_section_meta;

$yesno = array( "off"=>"No", "on"=>"Yes" );

$editorial_section_meta = array(
	
	array(  
    "name" => "Section Id",
    "desc" => "This id can be used in queries.",
    "id" => "section_id",
    "std" => "",
    "type" => "text"
  ),
	
  array(  
    "name" => "Posts",
    "desc" => "Post ids seperated with comma",
    "id" => "post_list",
    "std" => "",
    "type" => "text"
  ),

  array(  
    "name" => "Max Posts",
    "desc" => "Number of posts for the section",
    "id" => "max_posts",
    "std" => "5",
    "type" => "number"
  ),

);

add_action( 'add_meta_boxes', 'ms_editorial_section_box' );
function ms_editorial_section_box()
{
  add_meta_box(
    'ms-editorial-box',           // Unique ID
    'Section Information',  // Box title
    'ms_editorial_section_metabox_content',  // Content callback, must be of type callable
    'section',                   // Post type
    'advanced',
    'high'
  );
}

add_action('edit_form_after_title', function() {
    global $post, $wp_meta_boxes;
    do_meta_boxes( get_current_screen(), 'advanced', $post );
    unset( $wp_meta_boxes[get_post_type($post)]['advanced'] );
});

function ms_editorial_section_metabox_content(){
    global $post, $editorial_section_meta;
    $current = array();
    $post_meta = get_post_meta( $post->ID );

    foreach ( $editorial_section_meta as $field ) {
        if( array_key_exists( $field['id'], $post_meta ) ){
            $current[ $field['id'] ] = $post_meta[ $field['id'] ][0]; 
        }
    }

    ?>

<style>
.cstv-flex-wrap {
    display: flex;
}.col {
    flex-basis: 0;
    flex-grow: 1;
}
.cstv-input { margin-bottom: 10px }
.cstv-input small {
    font-size: 12px;
    color: #999;
    font-style: italic;
    margin-left: 10px;
}
.cstv-input label { font-size: 14px; font-weight: bold; }
.cstv-input input, .cstv-input select { border-radius: 4px;
    line-height: 30px;
    padding: 0 8px;
    background: #FFF9C4; }
.cstv_text input { width: 100%; }
.cstv-input textarea {
    width: 99%;
    border-radius: 4px;
    background: #def;
    padding: 8px 8px;
    min-height: 100px;
}
</style>
<div class="cstv-wrap">
    <?php

    foreach ( $editorial_section_meta as $field ) {
        switch ( $field['type'] ) {
            case 'col-open': ?>
                <div class="col">
<?php
            break;
            case 'col-close': ?>
                </div>
<?php
            break;
            case 'text': ?>
<div class="cstv-input cstv_text cf">
    <label for="<?php echo $field['id']; ?>"><?php echo $field['name']; ?></label>
    <small><?php echo $field['desc']; ?></small>
    <input name="<?php echo $field['id']; ?>" id="<?php echo $field['id']; ?>" type="<?php echo $field['type']; ?>" value="<?php if ( isset($current[ $field['id'] ]) && $current[ $field['id'] ] != "") { echo esc_html(stripslashes($current[ $field['id'] ] ) ); } ?>" />
</div>
<?php
            break;
            case 'number': ?>
            <div class="cstv-input cstv_number cf">
                <label for="<?php echo $field['id']; ?>"><?php echo $field['name']; ?></label> <input type="number" name="<?php echo $field['id']; ?>" id="<?php echo $field['id']; ?>" value="<?php if ( isset($current[ $field['id'] ]) && $current[ $field['id'] ] != "") { echo esc_html(stripslashes($current[ $field['id'] ] ) ); } else { echo "0"; } ?>" /> <small><?php echo $field['desc']; ?></small>
                
            </div>
            <?php
            break;
            case 'date': ?>
<div class="cstv-input cstv_text cf">
<label for="<?php echo $field['id']; ?>"><?php echo $field['name']; ?></label>
    <input name="<?php echo $field['id']; ?>" id="<?php echo $field['id']; ?>" type="<?php echo $field['type']; ?>" value="<?php if ( isset($current[ $field['id'] ]) && $current[ $field['id'] ] != "") { echo date( 'Y-m-d', $current[ $field['id'] ] ); } ?>" />
<small><?php echo $field['desc']; ?></small>
</div>
<?php
                        break;
            case 'select':
?>
<div class="cstv-input cstv_select cf">
<label for="<?php echo $field['id']; ?>"><?php echo $field['name']; ?></label>

<select name="<?php echo $field['id']; ?>" id="<?php echo $field['id']; ?>">
<?php foreach ($field['options'] as $key=>$name) { ?>
    <option <?php if ( isset($current[ $field['id'] ]) && $current[ $field['id'] ] == $key) { echo 'selected="selected"'; } ?> value="<?php echo $key;?>"><?php echo $name; ?></option><?php } ?>
</select>
<small><?php echo $field['desc']; ?></small>
</div>
<?php
            break;
            case 'textarea':
?>
<div class="cstv-input cstv_textarea cf">
<label for="<?php echo $field['id']; ?>"><?php echo $field['name']; ?></label>
 <textarea name="<?php echo $field['id']; ?>" type="<?php echo $field['type']; ?>" cols="" rows=""><?php if ( $current[ $field['id'] ] != "") { echo stripslashes($current[ $field['id'] ] ); } else { echo $field['std']; } ?></textarea>
<small><?php echo $field['desc']; ?></small>
</div>
<?php
            break;
        }

        
    }

    echo "</div>"; 
}

add_action( 'save_post', 'ms_editorial_save_section' );
function ms_editorial_save_section( $post_id )
{
  global $editorial_section_meta;

  foreach ( $editorial_section_meta as $field ) {
    if( array_key_exists( $field['id'], $_POST ) ){
      $value = '';
      if( $field['type'] == 'date' ){
        $value = strtotime( $_POST[ $field['id'] ] );
      } else {
        $value = $_POST[ $field['id'] ];
      }

      update_post_meta(
        $post_id,
        $field['id'],
        $value
      ); 
    }
  }

}
