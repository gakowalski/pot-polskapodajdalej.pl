jQuery(document).ready(function() {
  jQuery('#copyAttribs').change(function() {
    if(this.checked) {
      jQuery('#selectRegion').hide();
      jQuery('#selectType').hide();
      jQuery('#selectYear').hide();
    } else {
      jQuery('#selectRegion').show();
      jQuery('#selectType').show();
      jQuery('#selectYear').show();
    }
  });
});
