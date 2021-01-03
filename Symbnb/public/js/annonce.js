$('#addImage').click(function(){
    const index= +$('widgets-counter').val(); //va renvoyer le nombre de div qui ont la class form-group dans annonces_images
    //le + indique que le champ est un nombre
    //récupe le prototype des entrées = le code qui va permettre de générer un nouveau formulaire
    const tplt = $('#annonce_images').data('prototype').replace(/__name__/g, index);

    console.log(tplt);
    //j'injecte dans la div

    $('#annonce_images').append(tplt);
    $('#widgets-counter').val(index+1);

    //gestion du boutton supprimer (à chaque fois qu'on crée un nouveau champ)
    handleDeleteButtons();

});

function handleDeleteButtons(){
    $('button[data-action="delete"]').click(function(){
        const target= this.dataset.target;

        console.log(target); //contient l'id de la target
        $(target).remove();
    })
}

function updateCounter(){
    const count = +$('#annonce_images div.form-group').length;
    $('#widgets-counter').val(count);

}

updateCounter();
//gestion du boutton supprimer à chaque fois qu'on recharge la page
handleDeleteButtons();