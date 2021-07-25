// hide elements that don't contain the search keyword
// $(document).ready(function(){
//     $("#searchInput").on("keyup", function() {
//       var value = $(this).val().toLowerCase();

//         $("#myTable .tr").filter(function() {



//             $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)


//         });
//         if($(".tr").text().toLowerCase().indexOf(value)===-1){
//             $('.btn-danger').hide()
//             $('.pagination').hide()


//         }else{
//             $('.btn-danger').show()
//             $('.pagination').show()
//         }
//     });


// If person's property chosen, search input enabled
//If search input contains something -> post request via ajax to ajaxSearchAction with query, personProperty, limit, currentPage
// @success: each table row is removed, pagination container is removed, new table rows from ajax response are inserted after the trHeader element, also the pagination container is taken from the ajax response and inserted after the table element
$(document).ready(function () {
    $('#searchInput').prop('disabled', 'disabled')
    $('#personProperty').change(function () {

        if ($(this).val() !== '') {
            $('#searchInput').prop('disabled', false)
        } else {
            $('#searchInput').prop('disabled', true)
        }
        if ($('#searchInput').val() !== '') {
            var query = $('#searchInput').val().toLowerCase().trim();
            var personProperty = $(this).val();
            var limit = $('#ajaxPageLimit').val();

            $.ajax({
                url: $('#uri_hiddenSearch').val().trim(),
                data: {
                    'query': query,
                    'personProperty': personProperty,
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


    $("#searchInput").on("keyup", function () {

        var query = $(this).val().toLowerCase().trim();
        var personProperty = $('#personProperty').val();
        var limit = $('#ajaxPageLimit').val().trim();
        console.log(limit)
        $.ajax({
            url: $('#uri_hiddenSearch').val().trim(), // separate file for search
            data: {
                'query': query,
                'personProperty': personProperty,
                'limit': limit,
                'currentPage': 1
            },
            method: 'POST',

            success: function (response) {
                $(' .tr').remove()

                var tableRowHtml = Mustache.render(tableRowTemplate, response)
                var paginationHtml = Mustache.render(paginationTemplate, response)
                $('#trHeader').after(tableRowHtml)
                $('.pagination').remove()


                $('#table').after(paginationHtml)

            },
            error: function () {

            }
        });
    });


    // Disable CreateNew-Button, if no Company was chosen
    $('#submitPerson').prop('disabled', true)
    $('#select').on('change', function () {

        if ($('#select').val() !== '' && $('input:text').val() !== '') {
            $('#submitPerson').prop('disabled', false)
        } else {
            $('#submitPerson').prop('disabled', true)
        }
    })

    $('#newPerson  :input:text').on('change', function () {

        if ($('#newPerson  :input:text').val() !== '' && $('#select').val() !== '') {
            $('#submitPerson').prop('disabled', false)
        } else {
            $('#submitPerson').prop('disabled', true)
        }
    })


    var paginationTemplate = `
                        {{^onlyOnePage}}
                            <ul class="pagination">
                            {{#previousPage}}
                                <li class="page-item">
                                    <button class="page-link" id="previousButton" type="submit" name="" value="{{.}}">
                                        Previous
                                    </button>
                                </li>
                                {{/previousPage}}
                                {{#pages}}
                                <li class="page-item">
                                    <button class="page-link personPageButton"  type="submit" name="" value="{{.}}">
                                       {{.}}
                                    </button>
                                </li>

                                {{/pages}}
                            {{^isLastPage}}
                                {{#nextPage}}
                                <li class="page-item">
                                    <button class="page-link" id="nextButton" type="submit" name="" value="{{.}}">
                                        Next
                                    </button>
                                </li>
                                {{/nextPage}}
                            {{/isLastPage}}
                            </ul>
                    {{/onlyOnePage}}
                    `


    var tableRowTemplate = `{{#persons}}
                   <tr class="tr">
           
                           <td>
           
                            <input id="anrede" type="text" disabled="true"value="{{anrede}}" class="form-control personProperty"></input>
           
                           
                                
                           </td>
                           <td>
           
                           <input  id="vorname" type="text" disabled="true" value="{{vorname}}" class="form-control personProperty"></input>
           
                           
                                
                           </td>
                           <td>
           
                           <input id="nachname" type="text" disabled="true" value="{{nachname}}" class="form-control personProperty"></input>
           
                           
                                
                           </td>
                           <td>
           
                           <input type="text" id="email" disabled="true" value="{{email}}" class="form-control personProperty"></input>
           
                           
                                
                           </td>
                           <td>
           
                           <input type="text" id="telefon" disabled="true" value="{{telefon}}" class="form-control personProperty"></input>
           
                           
                                
                           </td>
                           <td>
           
                           <input type="text" id="handy" disabled="true" value="{{handy}}" class="form-control personProperty"></input>
           
                           
                                
                           </td>
                           <td>
                            
                          <a class="firma" href="#">{{firmaName}}</a>
           
                          <div id="selectCompany"></div>
                                
                           </td>
                           <td>
           
                           <button class="btn btn-primary editButton" value={{uid}} type="button" >
                           Updaten
                           </button>
                           
                    <input hidden class="uri_hiddenPersonUid" value="{{uid}}"/>
                           
                                
                           </td>
                           <td>
           
                         
                            <input class="personsToDeleteCheckbox" type="checkbox" name="personsToDelete" value="{{uid}}">
                           
                                
                           </td>
                 
           
                   </tr>
           
           {{/persons}}`


    var selectTemplate =
        ` <select name="companies"  class="form-control" class="companies">
                        {{#companies}}
                      
                        <option value={{uid}}>{{name}}</option>
                
                        {{/companies}}
                    </select>`
    $(this).on('click', ':button.personPageButton, :button#nextButton, :button#previousButton', function () {

        var currentPageNumber = $(this).val();

        var controllerpath = $("#uri_hidden").val();
        var ajaxPageLimit = $('#ajaxPageLimit').val()
        if ($('#personProperty').val() === '' && $('#searchInput').val() === '') {


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



                    $('.pagination').remove()
                    $('#paginationContainer').append(pagintationHtml)

                    $(`button[value=${response.currentPage}]`).closest('li').addClass('disabled')


                    // persons = {}
                    // persons.person=[]
                    console.log(response)
                    var personList = []
                    // var person= new Object()
                    response.persons.map(function (curr) {

                        personList.push(curr)

                    })
                    console.log(response)
                    // var persons=JSON.stringify(persons)
                    // persons={persons:persons}
                    var html = Mustache.render(tableRowTemplate, { persons: personList })



                    $('#trHeader').after(html)










                }
            })

        } else {
            var controllerpath = $("#uri_hiddenSearch").val();
            var limit = $("#ajaxPageLimit").val();
            var query = $("#searchInput").val();
            var currentPageNumber = $(this).val();
            var personProperty = $('#personProperty').val()

            $.ajax({
                type: "POST",
                url: controllerpath,
                data: { 'currentPage': currentPageNumber, 'limit': limit, 'query': query, 'personProperty': personProperty },
                success: function (response) {
                    $('.tr').each(function () {
                        $(this).remove()
                    })

                    $('#currentLimit').val(limit)
                    $('#currentLimit').text(limit)
                    var pagintationHtml = Mustache.render(paginationTemplate, response)
                    $('#trHeader').after(tableRows)
                    var html = Mustache.render(tableRowTemplate, response)
                    $('#paginationContainer').remove()
                    $(`button[value=${response.currentPage}]`).closest('li').addClass('disabled')
                    $('#trHeader').after(html)
                    $('#paginationContainer').append(pagintationHtml)

                }
            })
        }
    })



    $(document).on('click', '.editButton', function () {
        $('.editButton').removeClass('success')
        var personToEdit = $(this).next().val();


        $(this).toggleClass('letsUpdate btn-success')
        $(this).addClass('waitingToBeSubmitted')
        if ($(this).hasClass('letsUpdate')) {

            $(this).text('Bestätige!')
            $(this).parents('tr').find("td").find(".personProperty").prop('disabled', false)

            $.when($(this).parents('tr').find('td').find('.firma').fadeOut('slow')).then(function () {
                $('.waitingToBeSubmitted').prop('disabled', true)

                controllerPath = $('.uri_hiddenAllCompanies').val()
                $.ajax({
                    type: "GET",
                    url: controllerPath,

                    success: function (response) {








                        var html = Mustache.render(selectTemplate, { companies: response })


                        $('.letsUpdate').parents('tr').find('td').find('#selectCompany').append(html)


                        $('.waitingToBeSubmitted').prop('disabled', false)


                    },
                    error: function (err) {

                    }
                })
            })

        } else {

            controllerpath = $('.uri_hiddenUpdate').val()
            $.ajax({
                type: "POST",
                url: controllerpath,
                data: {
                    'tx_heiner_persons': {
                        anrede: $('.waitingToBeSubmitted').parents('tr').find('td').find('#anrede').val(),
                        vorname: $('.waitingToBeSubmitted').parents('tr').find('td').find('#vorname').val(),
                        nachname: $('.waitingToBeSubmitted').parents('tr').find('td').find('#nachname').val(),
                        email: $('.waitingToBeSubmitted').parents('tr').find('td').find('#email').val(),
                        telefon: $('.waitingToBeSubmitted').parents('tr').find('td').find('#telefon').val(),
                        handy: $('.waitingToBeSubmitted').parents('tr').find('td').find('#handy').val(),
                        firma: $('select[name="companies"]').val(),
                        uid: personToEdit

                    }
                },
                success: function (response) {

                    $('.waitingToBeSubmitted').addClass('success')

                    // $('.success').parents('tr').find("td").find('.firma').show()

                    $('.waitingToBeSubmitted').parents('tr').find('td').find('.uri_hiddenUpdatedCompanyName').val(response.firma)





                    $('.editButton').parents('tr').find("td").find(".personProperty").prop('disabled', true)
                    $('.editButton').text('Updaten')
                    console.log(response[0].firma)
                    $('.waitingToBeSubmitted').prop('disabled', false)
                    $.when($('#companies').fadeOut('slow')).then(function () {
                        console.log('hello')
                        $('select[name="companies"]').remove()
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

                    })








                }
            })


        }






    })
    $(this).on('change', '#selectCompany', function () {
        console.log('123')
        $('.letsUpdate').parents('tr').find('td').find('.firma').text($('select[name="companies"] :selected').text())
    })
    $('#ajaxPageLimit').change(function () {

        var val = $('#ajaxPageLimit').val();

        var personProperty = $('#personProperty').val();
        var searchInput = $('#searchInput').val();


        const pageNumber = $('.page-item.disabled').find('#pageButton').val()

        var controllerpath = $("#uri_hidden").val();

        if (personProperty == '' && searchInput == '') {


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

                    $('#ajaxPageLimit option').show();
                    $('#ajaxPageLimit option:selected').hide();


                    $('#trHeader').after(tableRowHtml)

                }

            })

        } else {
            var val = $('#ajaxPageLimit').val();

            var query = $('#searchInput').val().toLowerCase().trim();
            var personProperty = $('#personProperty').val().trim();
            var limit = $('#ajaxPageLimit').val().trim();
            console.log(limit)
            $.ajax({
                url: $('#uri_hiddenSearch').val().trim(), // separate file for search
                data: {
                    'query': query,
                    'personProperty': personProperty,
                    'limit': limit,
                    'currentPage': 1
                },
                method: 'POST',

                success: function (response) {
                    $('.tr').remove()
                    var tableRows = $(response).find('.tr')
                    $('#ajaxPageLimit option').show();
                    $('#ajaxPageLimit option:selected').hide();
                    $('#trHeader').after(tableRows)
                    $('#paginationContainer').remove()
                    $('#currentLimit').val(val)
                    $('#currentLimit').text(val)
                    var pagination = $(response).find('#paginationContainer')
                    $('#table').after(pagination)

                },
                error: function () {

                }
            });
        }

    })

    // $(this).on('click', '.waitingToBeSubmitted', function () {

    //     console.log($('.uri_hiddenUpdatedCompanyName').val())
    //     $('.waitingToBeSubmitted').parents('tr').find('td').find('.firma').text($('.uri_hiddenUpdatedCompanyName').val())

    //     $('.waitingToBeSubmitted').parents('tr').find('td').find('.firma').show()
    // })
    $(this).on('change', '.personsToDeleteCheckbox', function () {
        $('tr').not(':has(:checkbox:checked)').removeClass('waitingToBeRemoved')
        $('tr').filter(':has(:checkbox:checked)').each(function () {
            $(this).addClass('waitingToBeRemoved')

        });

    })
    $('#myTable').on('change', function () {

        $(this).each(function () {

            $('.personsToDeleteCheckbox:checkbox:checked').length > 0 ? $('#deletePersons').fadeIn() : $('#deletePersons').fadeOut()

        })
    })

    $('#deletePersons').on('click', function () {

        var personsToDelete = []
        $("input:checkbox:checked").each(function () {
            personsToDelete.push($(this).val());
        });
        $.ajax({
            url: $('.uri_hiddenDelete').val(), // separate file for search
            data: {
                personsToDelete: personsToDelete
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


                $('#deletePersons').fadeOut('slow')




            }



        })



    })
})
