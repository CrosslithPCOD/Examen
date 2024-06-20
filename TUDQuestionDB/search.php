<?php
require 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['clean_database'])) {
    $vraag->deleteAll();
}
?>

<h1 style="text-align:center;">Search Questions</h1>

<div class="container">
    <div class="left-column-2">
        <h3>View Specific Question</h3>
        <form action="read.php" method="post">
            <div class="autocomplete-container" style="width:300px;">
                <input type="text" id="title" name="input" placeholder="Question Title">
                <div id="autocomplete-results-title"></div>
            </div>
            <input type="submit" name="submit" value="View">
        </form>
    </div>
    <div class="right-column-2">
        <h3>Delete Question</h3>
        <form action="conn/delete.php" method="post">
            <div class="autocomplete-container" style="width:300px;">
                <input type="text" id="deleteTitle" name="input" placeholder="Question Title or ID">
                <div id="autocomplete-results-delete"></div>
            </div>
            <input type="submit" name="submit" value="Delete">
        </form>
        <br>
        <h3>Purge Database</h3>
        <form action="" method="post" onsubmit="return confirmCleanDatabase();">
            <div class="autocomplete-container" style="width:300px;">
            </div>
            <input type="hidden" name="clean_database" value="1"> 
            <input type="submit" name="submit" value="Purge Database">
        </form>
    </div>
</div>
<br>
<?php
$vraag->showSelectVragen();
?>

<script>
function search() {
    const fields = [
        'id', 'title', 'question', 'feedback', 'pool', 'tags', 
        'courses', 'chapters', 'categories', 'exams'
    ];

    const searchValues = fields.reduce((acc, field) => {
        acc[field] = document.getElementById('search_' + field).value.toLowerCase();
        return acc;
    }, {});

    const rows = document.getElementsByClassName('vraagRow');

    for (let row of rows) {
        let showRow = true;
        for (let field of fields) {
            const cellValue = row.querySelector('.' + field).innerText.toLowerCase();
            if (!cellValue.includes(searchValues[field])) {
                showRow = false;
                break;
            }
        }
        row.style.display = showRow ? '' : 'none';
    }
}

function toggleSelectAll(source) {
    const checkboxes = document.querySelectorAll('.vraagRow input[type="checkbox"]');
    for (let i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].parentNode.parentNode.style.display !== 'none') {
            checkboxes[i].checked = source.checked;
        }
    }
}

function confirmCleanDatabase() {
    return confirm("Are you sure you want to clean the entire database? This action cannot be undone.");
}

$(document).ready(function() {
    // Autocomplete for Title
    $('#title').keyup(function() {
        var queryTitle = $(this).val();
        if (queryTitle.trim() !== '') {
            $.ajax({
                url: 'json/autocomplete.php',
                method: 'POST',
                data: {query: queryTitle},
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    $.each(data, function(index, item) {
                        html += '<div class="autocomplete-item">' + item.Title + '</div>';
                    });
                    $('#autocomplete-results-title').html(html);
                }
            });
        } else {
            $('#autocomplete-results-title').empty();
        }
    });

    // Autocomplete for Delete Title
    $('#deleteTitle').keyup(function() {
        var queryDelete = $(this).val();
        if (queryDelete.trim() !== '') {
            $.ajax({
                url: 'json/autocomplete.php',
                method: 'POST',
                data: {query: queryDelete},
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    $.each(data, function(index, item) {
                        html += '<div class="autocomplete-item">' + item.Title + '</div>';
                    });
                    $('#autocomplete-results-delete').html(html);
                }
            });
        } else {
            $('#autocomplete-results-delete').empty();
        }
    });

    // Handle click on autocomplete item
    $(document).on('click', '.autocomplete-item', function() {
        var selectedValue = $(this).text();
        $(this).closest('.autocomplete-container').find('input[type="text"]').val(selectedValue);
        $(this).parent().empty();
    });
});
</script>

<?php require 'footer.php'; ?>