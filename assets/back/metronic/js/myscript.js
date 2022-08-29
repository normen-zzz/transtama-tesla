const flashData = $('.flash-data').data('flashdata');
// console.log(flashData);

if(flashData){
   
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        Toast.fire({
            icon: 'info',
            title: 'Data ' + flashData
        })

}

// tombol hapus

$('.tombol-hapus').on('click', function(e){
    e.preventDefault();
    const hreff = $('this').attr('href');
    Swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
        
           document.location.href = hreff;
          
        }
      })

});
