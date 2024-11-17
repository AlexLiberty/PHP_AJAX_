<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Фільтрація співробітників</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1>Список співробітників</h1>

<div>
    <label for="country_filter">Країна:</label>
    <select id="country_filter">
        <option value="">Усі країни</option>
    </select>

    <label for="city_filter">Місто:</label>
    <select id="city_filter">
        <option value="">Усі міста</option>
    </select>

    <label for="salary_sort">Сортування за зарплатою:</label>
    <select id="salary_sort">
        <option value="asc">По зростанню</option>
        <option value="desc">По спаданню</option>
    </select>
</div>
<br>
<table id="employees_table">
    <thead>
    <tr>
        <th><a href="#" class="sortable" data-sort="Name">Ім'я</a></th>
        <th><a href="#" class="sortable" data-sort="Surname">Прізвище</a></th>
        <th><a href="#" class="sortable" data-sort="Country">Країна</a></th>
        <th><a href="#" class="sortable" data-sort="City">Місто</a></th>
        <th><a href="#" class="sortable" data-sort="Salary">Зарплата</a></th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<script>
    function loadData(filters)
    {
        $.ajax({
            url: 'get_data.php',
            type: 'GET',
            data: filters,
            success: function(response)
            {
                $('#employees_table tbody').html(response);
            }
        });
    }

    function loadFilters()
    {
        $.ajax({
            url: 'get_filters.php',
            type: 'GET',
            success: function(response)
            {
                const filters = JSON.parse(response);

                filters.countries.forEach(country =>
                {
                    $('#country_filter').append(`<option value="${country}">${country}</option>`);
                });

                filters.cities.forEach(city =>
                {
                    $('#city_filter').append(`<option value="${city}">${city}</option>`);
                });
            }
        });
    }

    $(document).on('click', '.sortable', function(e)
    {
        e.preventDefault();
        const sortBy = $(this).data('sort');
        const currentSort = $('#salary_sort').val();

        loadData({
            sort_by: sortBy,
            sort_order: currentSort
        });
    });

    $('#country_filter, #city_filter, #salary_sort').change(function()
    {
        loadData({
            country: $('#country_filter').val(),
            city: $('#city_filter').val(),
            sort_by: 'Salary',
            sort_order: $('#salary_sort').val()
        });
    });

    $(document).ready(function()
    {
        loadFilters();
        loadData({});
    });
</script>

</body>
</html>
