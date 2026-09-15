if( jQuery( '#easy_wp_description' ) !== undefined ){
  update_output( event ) ;
  jQuery( '#easy_wp_description' ).on( 'keyup', update_output );
}

function update_output( event ){
  var value = jQuery( '#easy_wp_description' ).val();
  if( value  !== undefined ){
    var n = value.length;
    jQuery( '#easy_wp_output' ).text( n );
  }
}
