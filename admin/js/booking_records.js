


function get_bookings(search='',page=1) {
 

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/booking_records.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); //(for uploadng using Header is not used because we use formData because formDAta hedar request is already load) 
    xhr.onload = function () {
        let data = JSON.parse(this.responseText);
        document.getElementById('table-data').innerHTML = data.table_data;
        document.getElementById('table-pagination').innerHTML = data.pagination;

    }
    xhr.send('get_bookings&search='+search+'&page='+page);
}

function change_page(page){
    get_bookings(document.getElementById('search_input').value,page);
}


function download(id){
  window.location.href = 'generate_pdf.php?gen_pdf&id='+id;
}
window.onload = get_bookings();