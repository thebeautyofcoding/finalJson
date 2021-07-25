
$(document).ready(function () {
    //     $(this).on('click', ':button.page-link', '#nextButton', '#previousButton', function () {







    //         console.log($(this).val())

    //         var currentPageNumber = $(this).val();

    //         var controllerpath = $("#uri_hidden").val();
    //         var ajaxPageLimit = $('#ajaxPageLimitCompany').val()
    //         console.log(currentPageNumber, ajaxPageLimit)
    //         $.ajax({
    //             type: "POST",
    //             url: controllerpath,
    //             data: { 'pageNumber': currentPageNumber, 'ajaxPageLimit': ajaxPageLimit },
    //             success: function (response) {
    //                 $('.tr').each(function () {
    //                     $(this).remove()
    //                 })




    //                 $('#defaultLimit').val(ajaxPageLimit)
    //                 $('#defaultLimit').text(ajaxPageLimit)
    //                 var tableRows = $(response).find('.tr')
    //                 $('#trHeader').after(tableRows)
    //                 console.log(tableRows)
    //                 $('#paginationContainer').remove()

    //                 var pagination = $(response).find('#paginationContainer')
    //                 $('#table').after(pagination)

    //             }
    //         })





    //     })

    $('#searchInputCompany').prop('disabled', 'disabled')
    $('#companyProperty').change(function () {

        if ($(this).val() !== '') {
            $('#searchInputCompany').prop('disabled', false)
        } else {
            $('#searchInputCompany').prop('disabled', true)
        }
        if ($('#searchInputCompany').val() !== '') {
            var query = $('#searchInputCompany').val().toLowerCase().trim();
            var companyProperty = $(this).val();
            var limit = $('#ajaxPageLimitCompany').val();

            $.ajax({
                url: $('#uri_hiddenSearchCompany').val().trim(),
                data: {
                    'query': query,
                    'companyProperty': companyProperty,
                    'limit': limit,
                    'currentPage': 1
                },
                method: 'POST',

                success: function (response) {
                    $('.tr').remove()
                    var tableRows = $(response).find('.tr')

                    $('#trHeader').after(tableRows)
                    $('#paginationContainer').remove()

                    var pagination = $(response).find('#paginationContainer')
                    $('#table').after(pagination)

                },
                error: function () {
                    alert("something has gone wrong");
                }
            });
        }

    })
    $("#searchInputCompany").on("keyup", function () {

        var query = $(this).val().toLowerCase().trim();
        var companyProperty = $('#companyProperty').val();
        var limit = $('#ajaxPageLimitCompany').val();
        console.log(limit)
        $.ajax({
            url: $('#uri_hiddenSearchCompany').val().trim(), // separate file for search
            data: {
                'query': query,
                'companyProperty': companyProperty,
                'limit': limit,
                'currentPage': 1
            },
            method: 'POST',

            success: function (response) {
                $('.tr').remove()

                tableRowTemplateHtml = Mustache.render(tableRowTemplate, response)
                paginationTemplateHtml = Mustache.render(paginationTemplate, response)
                $('#trHeader').after(tableRowTemplateHtml)
                $(`button[value=${response.currentPage}]`).closest('li').addClass('disabled')
                $('.pagination').remove()


                $('#table').after(paginationTemplateHtml)

            },
            error: function () {

            }
        });
    });






    $(this).on('click', '.companyPageButton, :button#nextButtonCompany, :button#previousButtonCompany', function () {
        console.log('hello')
        var currentPageNumber = $(this).val();

        var controllerpath = $("#uri_hiddenCompany").val();
        console.log(controllerpath)
        var ajaxPageLimit = $('#ajaxPageLimitCompany').val()
        if ($('#companyProperty').val() === '' && $('#searchInputCompany').val() === '') {


            $.ajax({
                type: "POST",
                url: controllerpath,



                data: { 'pageNumber': currentPageNumber, 'ajaxPageLimit': ajaxPageLimit },
                success: function (response) {

                    $('.tr').each(function () {
                        $(this).remove()
                    })

                    $('#currentLimit').val(ajaxPageLimit)
                    $('#currentLimit').text(ajaxPageLimit)






                    var pagintationHtml = Mustache.render(paginationTemplate, response)
                    var tableRowTemplateHtml = Mustache.render(tableRowTemplate, response)

                    console.log($(`button[value=${response.currentPage}]`).closest('li'))

                    $('.pagination').remove()
                    $('#paginationContainer').append(pagintationHtml)

                    $(`button[value=${response.currentPage}]`).closest('li').addClass('disabled')


                    // persons = {}
                    // persons.person=[]
                    console.log(response)
                    var companyList = []
                    // var person= new Object()
                    response.companies.map(function (curr) {

                        companyList.push(curr)

                    })

                    // var persons=JSON.stringify(persons)
                    // persons={persons:persons}
                    var html = Mustache.render(tableRowTemplateHtml, { companies: companyList })



                    $('#trHeader').after(html)










                }
            })

        } else {
            var controllerpath = $("#uri_hiddenSearchCompany").val();
            var limit = $("#ajaxPageLimitCompany").val();
            var query = $("#searchInputCompany").val();
            var currentPageNumber = $(this).val();
            var companyProperty = $('#companyProperty').val()

            $.ajax({
                type: "POST",
                url: controllerpath,
                data: { 'currentPage': currentPageNumber, 'limit': limit, 'query': query, 'companyProperty': companyProperty },
                success: function (response) {
                    $('.tr').each(function () {
                        $(this).remove()

                    }
                    )
                    $('.pagination').remove()


                    paginationHtml = Mustache.render(paginationTemplate, response)
                    tableRowHtml = Mustache.render(tableRowTemplate, response)

                    $('#paginationContainer').append(paginationHtml)



                    $('#ajaxPageLimitCompany option').show();
                    $('#ajaxPageLimitCompany option:selected').hide();
                    $(`button[value=${response.currentPage}]`).closest('li').addClass('disabled')

                    $('#trHeader').after(tableRowHtml)

                }
            })
        }
    })
    var paginationTemplate = `
                        {{^onlyOnePage}}
                            <ul class="pagination">
                            {{#previousPage}}
                                <li class="page-item">
                                    <button class="page-link" id="previousButtonCompany" type="submit" name="" value="{{.}}">
                                        Previous
                                    </button>
                                </li>
                                {{/previousPage}}
                                {{#pages}}
                                <li class="page-item">
                                    <button class="page-link companyPageButton"  type="submit" name="" value="{{.}}">
                                       {{.}}
                                    </button>
                                </li>

                                {{/pages}}
                            {{^isLastPage}}
                                {{#nextPage}}
                                <li class="page-item">
                                    <button class="page-link" id="nextButtonCompany" type="submit" name="" value="{{.}}">
                                        Next
                                    </button>
                                </li>
                                {{/nextPage}}
                            {{/isLastPage}}
                            </ul>
                   {{/onlyOnePage}}
                    `
    var tableRowTemplate = `{{#companies}}
                   <tr class="tr">
           
                           <td>
           
                            <input id="name" type="text" disabled="true"value="{{name}}" class="form-control companyProperty"></input>
           
                           
                                
                           </td>
                           <td>
           
                           <input  id="unterzeile" type="text" disabled="true" value="{{unterzeile}}" class="form-control companyProperty"></input>
           
                           
                                
                           </td>
                           <td>
           
                           <input id="strasse" type="text" disabled="true" value="{{strasse}}" class="form-control companyProperty"></input>
           
                           
                                
                           </td>
                           <td>
           
                           <input type="text" id="plz" disabled="true" value="{{plz}}" class="form-control companyProperty"></input>
           
                           
                                
                           </td>
                           <td>
           
                           <input type="text" id="ort" disabled="true" value="{{ort}}" class="form-control companyProperty"></input>
           
                           
                                
                           </td>
                           <td>
           
                           <input type="text" id="telefon" disabled="true" value="{{telefon}}" class="form-control companyProperty"></input>
           
                           
                                
                           </td>
                           <td>
           
                           <input type="text" id="fax" disabled="true" value="{{fax}}" class="form-control companyProperty"></input>
           
                           
                                
                           </td>
                           <td>
           
                           <input type="text" id="web" disabled="true" value="{{web}}" class="form-control companyProperty"></input>
           
                           
                                
                           </td>
                           
                           <td>
           
                           <button class="btn btn-primary editButtonCompany" value={{uid}} type="button" >
                           Updaten
                           </button>
                           
                    <input hidden class="uri_hiddenCompanyUid" value="{{uid}}"/>
                           
                                
                           </td>
                           <td>
           
                         
                            <input class="companiesToDeleteCheckbox" type="checkbox" name="companiesToDelete" value="{{uid}}">
                           
                                
                           </td>
                 
           
                   </tr>
           
           {{/companies}}`


    $('#ajaxPageLimitCompany').on('change', function () {
        console.log('hello')
        var val = $('#ajaxPageLimitCompany').val();

        var companyProperty = $('#companyProperty').val();
        var searchInput = $('#searchInputCompany').val();


        const pageNumber = $('.page-item.disabled').find('.companyPageButton').val()

        var controllerpath = $("#uri_hiddenCompany").val();

        if (companyProperty == '' && searchInput == '') {


            $.ajax({
                type: "POST",
                url: controllerpath,
                data: { 'ajaxPageLimit': val, 'pageNumber': 1 },
                success: function (response) {
                    $('.tr').each(function () {
                        $(this).remove()

                    }
                    )
                    $('.pagination').remove()


                    paginationHtml = Mustache.render(paginationTemplate, response)
                    tableRowHtml = Mustache.render(tableRowTemplate, response)

                    $('#paginationContainer').append(paginationHtml)

                    $('#currentLimit').val(val)
                    $('#currentLimit').text(val)
                    $(`button[value=${response.currentPage}]`).closest('li').addClass('disabled')
                    $('#ajaxPageLimitCompany option').show();
                    $('#ajaxPageLimitCompany option:selected').hide();


                    $('#trHeader').after(tableRowHtml)

                }

            })

        } else {
            var val = $('#ajaxPageLimitCompany').val();

            var query = $('#searchInputCompany').val().toLowerCase().trim();
            var companyProperty = $('#companyProperty').val().trim();
            var limit = $('#ajaxPageLimitCompany').val().trim();

            $.ajax({
                url: $('#uri_hiddenSearchCompany').val().trim(), // separate file for search
                data: {
                    'query': query,
                    'companyProperty': companyProperty,
                    'limit': limit,
                    'currentPage': 1
                },
                method: 'POST',

                success: function (response) {
                    $('.tr').remove()
                    var tableRows = $(response).find('.tr')
                    $('#ajaxPageLimitCompany option').show();
                    $('#ajaxPageLimitCompany option:selected').hide();
                    $('#trHeader').after(tableRows)
                    $('.pagintion').remove()
                    $('#currentLimit').val(val)
                    $('#currentLimit').text(val)
                    paginationHtml = Mustache.render(paginationTemplate, response)
                    tableRowHtml = Mustache.render(tableRowTemplate, response)
                    $('.pagination').remove()
                    $('#paginationContainer').append(paginationHtml)

                    $(`button[value=${response.currentPage}]`).closest('li').addClass('disabled')


                    $('#trHeader').after(tableRowHtml)


                },
                error: function () {

                }
            });
        }

    })


    $(this).on('change', '.companiesToDeleteCheckbox', function () {


        $('tr').not(':has(:checkbox:checked)').removeClass('waitingToBeRemoved')
        $('tr').filter(':has(:checkbox:checked)').each(function () {
            $(this).addClass('waitingToBeRemoved')

        });




    })
    var $input = $('#newCompany  :input:text')
    $submit = $('#submitCompany');
    $submit.attr('disabled', true);

    $input.keyup(function () {
        var trigger = false;
        $input.each(function () {
            if (!$(this).val()) {
                trigger = true;
            }
        });
        trigger ? $submit.attr('disabled', true) : $submit.removeAttr('disabled');
    });




    $('#myTable ').on('change', function () {
        $(this).each(function () {

            $('.companiesToDeleteCheckbox:checkbox:checked').length > 0 ? $('#deleteCompanies').fadeIn() : $('#deleteCompanies').fadeOut()

        })
    })


    $('#deleteCompanies').on('click', function () {






        var companiesToDelete = []
        $("input:checkbox:checked").each(function () {
            companiesToDelete.push($(this).val());
        });
        $.ajax({
            url: $('.uri_hiddenDeleteCompanies').val(), // separate file for search
            data: {
                companiesToDelete: companiesToDelete
            },
            method: 'POST',

            success: function (response) {


                $('.waitingToBeRemoved').css({
                    'background-color': '#f60000',
                    'color': '#fff'
                });
                $('.waitingToBeRemoved').fadeOut('slow', function () {
                    $(this).remove();
                })


                $('#deleteCompanies').fadeOut('slow')




            }



        })



    })
    $(document).on('click', '.editButtonCompany', function () {
        $('.editButtonCompany').removeClass('success')

        controllerpath = $('.uri_hiddenUpdateCompany').val()

        $(this).toggleClass('letsUpdate btn-success')
        $(this).addClass('waitingToBeSubmitted')
        if ($(this).hasClass('letsUpdate')) {

            $(this).text('Bestätige!')
            $(this).parents('tr').find("td").find(".companyProperty").prop('disabled', false)











        }






    })
    $(document).on('click', '.editButtonCompany.waitingToBeSubmitted', function () {
        var companyToEdit = $(this).next().val();
        $.ajax({
            type: "POST",
            url: controllerpath,
            data: {
                'tx_heiner_companies': {
                    name: $('.waitingToBeSubmitted').parents('tr').find('td').find('#name').val(),
                    unterzeile: $('.waitingToBeSubmitted').parents('tr').find('td').find('#unterzeile').val(),
                    strasse: $('.waitingToBeSubmitted').parents('tr').find('td').find('#strasse').val(),
                    plz: $('.waitingToBeSubmitted').parents('tr').find('td').find('#plz').val(),
                    ort: $('.waitingToBeSubmitted').parents('tr').find('td').find('#ort').val(),
                    telefon: $('.waitingToBeSubmitted').parents('tr').find('td').find('#telefon').val(),
                    telefon: $('.waitingToBeSubmitted').parents('tr').find('td').find('#fax').val(),
                    web: $('.waitingToBeSubmitted').parents('tr').find('td').find('#web').val(),
                    firma: $('select[name="companies"]').val(),
                    uid: companyToEdit

                }
            },
            success: function (response) {

                $('.waitingToBeSubmitted').addClass('success')

                // $('.success').parents('tr').find("td").find('.firma').show()

                // $('.waitingToBeSubmitted').parents('tr').find('td').find('.uri_hiddenUpdatedCompanyName').val(response.firma)





                $('.editButtonCompany').parents('tr').find("td").find(".companyProperty").prop('disabled', true)
                $('.editButtonCompany').text('Updaten')
                console.log(response[0].firma)
                $('.waitingToBeSubmitted').prop('disabled', false)


                $('.waitingToBeSubmitted').prop('disabled', true)
                $('.waitingToBeSubmitted').parents('tr').find('td').find('.firma').text(response[0].firma)
                $('.waitingToBeSubmitted').parents('tr').find('.firma').fadeIn('slow')
                $('.waitingToBeSubmitted').parents('tr').animate({ backgroundColor: '#a1eea4' }, 600)
                var color = $('.waitingToBeSubmitted').parents('tr').css("background-color")
                setTimeout(function () {
                    console.log('DDJDJD')

                    $('.waitingToBeSubmitted').parents('tr').animate({ backgroundColor: color }, 600)
                    $('.waitingToBeSubmitted').prop('disabled', false)
                    $('button').removeClass('waitingToBeSubmitted')

                }, 1000);










            }
        })
    })

})









