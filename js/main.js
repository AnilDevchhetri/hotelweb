function setActive(){
    navbar = document.getElementById('main-nav-bar');
    let a_tags = navbar.getElementsByTagName('a');

    for(i=0;i<a_tags.length;i++){
        
        let file = a_tags[i].href.split('/').pop();
        let file_name = file.split('.')[0];
        if(document.location.href.indexOf(file_name)>=0){
            a_tags[i].classList.add("active");
        }
    }
}
setActive();