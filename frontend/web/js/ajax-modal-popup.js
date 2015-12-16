$(function(){
      $('.showModalButton').on('click',function(){
        if ($('#modal').data('bs.modal').isShown) {
            $('#modal').find('#modalContent')
                    .load($(this).attr('href'));
        } else {
            $('#modal').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('href'));
        }
        return false;
      });
      $('.showModalImageButton').on('click',function(){
        if ($('#modalImage').data('bs.modal').isShown) {
            $('#modalImage').find('#modalImageImg')
                    .attr('src', $(this).attr('href'));
        } else {
            $('#modalImage').modal('show')
                    .find('#modalImageImg')
                    .attr('src', $(this).attr('href'));
        }
        return false;
      });
});