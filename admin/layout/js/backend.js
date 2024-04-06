
$(function() {
    'use strict';

    // dashboard 

    $('.toggle-info').click(function() {

        $(this).toggleClass('selected').parent().next('.card-body').fadeToggle(100);

        if((this).hasClass('selected')) {

            $(this).html('<i class="fas fa-plus"></i>');

        } else {

            $(this).html('<i class="fas fa-minus"></i>');
        }

    });
    // ------------------------------------------------------
    // Switch Clients|Admins
    $('.members-title h4 .title').click(function() {

        $(this).addClass('selected').siblings().removeClass('selected');

        $('.members-table').hide();

        $('.' + $(this).data('class')).fadeIn(100);

    });
    // ------------------------------------------------------

    $('.add-item').click(function() {

        var rows = $('#items').val();
        $(this).parent().parent('.form-row').after("<?php $cmdItems =" + rows + "?>");
        $(this).parent().parent('.form-row').fadeToggle(100);
        });

    // ------------------------------------------------------

    $('input').each(function() {

        if($(this).attr('required') === 'required') {
            $(this).after('<span class="asterisk">*</span>');
        }

    });

    $('.confirm').click(function() {
        return confirm("Vous etes sure?");
    });

    const params = new Map(location.search.slice(1).split('&').map(kv => kv.split('=')))
    let paramtdo = params.get('do');
    let curentpath = window.location.pathname;

    if (curentpath == '/items.php' && paramtdo == 'Add') {


        function chargerFilterScategorie(idScategorie) {


            $.ajax({
                url: '/includes/ajax/ajax.php',
                type: 'POST',
                dataType: 'JSON',
                data: { "idScategorie": idScategorie },
                success: function(data) {
                    $('#display-filtre').html(data.codeSelectFilter);

                },
                error: function(xhr, status, thrown) {
                    console.log("ERROR : ", xhr);
                    console.log("STATUS : ", status);
                    console.log("THROWN : ", thrown);
                }

            });
        }

        //charger filtre s categoire
        chargerFilterScategorie($('select[name=souscategorie]').val());
        $('select[name=souscategorie]').change(function(e) {
            let idScategorie = $(this).val();
            chargerFilterScategorie(idScategorie);
        });

        /* ajouter champ pour fiche technique */
        $('.addchamp').click(function() {

            let element = $('.div-champ>input:last');
            let champ = $(element).attr('name', "champ").attr("placeholder", "champ");
            $('.div-champ>input:last').after(champ[0].outerHTML);
            let valeur = $(element).attr('name', "valeur").attr("placeholder", "valeur");
            $('.div-champ>input:last').after(valeur[0].outerHTML);


        });

        //creer ficher technique
        $('.creer-fichier').click(function() {
            let arraychamp = new Array();
            let arrayvaleur = new Array();
            $('input[name=champ]').each(function(index) {
                arraychamp.push($(this).val());
            });
            $('input[name=valeur]').each(function(index) {
                arrayvaleur.push($(this).val());
            });

            let nomfichier = $('input[name=nomfichier]').val();

            $.ajax({
                url: '/includes/ajax/ajax.php',
                type: 'POST',
                dataType: 'JSON',
                data: { "champ": arraychamp, "valeur": arrayvaleur, "nomFichier": nomfichier },
                success: function(data) {
                    alert("fichier creer dans le dossier ajax!");

                },
                error: function(xhr, status, thrown) {
                    console.log("ERROR : ", xhr);
                    console.log("STATUS : ", status);
                    console.log("THROWN : ", thrown);
                }
            });

        });
    } else if (curentpath == '/sousCategories.php' && paramtdo == 'Add') {


        //ajouter champ complet
        $('.addchampComplet').click(function() {

            let element = "<div class=\"div-champ\" style=\"margin:10px;\">" +
                "<input style=\"width:40%; \" type=\"text\"  class=\"form-control float-left d-inline-block\"  name=\"champ\"  placeholder=\"champ\" ></input>" +
                "<div class=\"d-inline-block\" style=\"    max-width: 40%;\"  >" +
                "<input type=\"text\"  class=\"form-control d-inline-block\"  name=\"valeur\"  placeholder=\"valeur\" ></input>" +
                "</div><button type=\"button\" style=\"width:20%; \" class=\"btn btn-secondary float-right addvaleur\">+</button></div>";


            $('.div-champ:last').after(element);


        });

        //ajouter valeur
        $(document).on('click', '.addvaleur', function(e) {
            /*let element = $('.div-champ>div>input[name=valeur]:last');
            let valeur = $(element).attr('name', "valeur").attr("placeholder", "valeur");
            $('.div-champ>div>input[name=valeur]:last').after(valeur[0].outerHTML);*/
            let element = $(this).prev().children(':last');
            let valeur = $(element).attr('name', "valeur").attr("placeholder", "valeur");
            element.after(valeur[0].outerHTML);
        });

        //creer filtre
        $('.creer-filtre-scategoire').click(function() {
            let arraychamp = {};
            $('input[name=champ]').each(function(index) {
                arraychamp[$(this).val()] = new Array();
                let col = $(this).val();

                $(this).next().children().each(function(index) {
                    arraychamp[col].push($(this).val());

                });
            });
            let nomfichier = $('input[name=nom-filtre]').val();

            $.ajax({
                url: '/includes/ajax/ajax.php',
                type: 'POST',
                dataType: 'JSON',
                data: { "arraychamp": JSON.stringify(arraychamp), "nomFiltre": nomfichier },
                success: function(data) {
                    alert("fichier creer dans le dossier ajax!");
                },
                error: function(xhr, status, thrown) {
                    console.log("ERROR : ", xhr);
                    console.log("STATUS : ", status);
                    console.log("THROWN : ", thrown);
                }
            });

        });
    }
});


