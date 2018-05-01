function turnOnSelect() {
    $('.ro-select').filter(function(){
    var $this = $(this),
        $sel = $('<ul>',{'class': 'ro-select-list'}),
        $wr = $('<div>', {'class': 'ro-select-wrapper'}),
        $inp = $('<input>', {
          type:'hidden', 
          name: $this.attr('name'),
          'class': 'ro-select-input'
        }),
        $text = $('<div>', {
          'class':'ro-select-text ro-select-text-empty',
          text: $this.attr('placeholder')
        });
        $opts = $this.children('option');
    
    $text.click(function(){
      $sel.show();
    });
    
    $opts.filter(function(){
      var $opt = $(this);
      $sel.append($('<li>',{text:$opt.text(), 'class': 'ro-select-item', 'value': $opt.attr('value')}));
    });
    $sel.on('click','li',function(){
      $text.text($(this).text()).removeClass('ro-select-text-empty');
      $(this).parent().hide().children('li').removeClass('ro-select-item-active');
      $(this).addClass('ro-select-item-active');
    });
    $wr.append($text);
    $wr.append($('<i>', {'class':'fa fa-caret-down ro-select-caret'}));
    $this.after($wr.append($inp,$sel));
    $this.remove();
  });
}