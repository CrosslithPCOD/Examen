<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtered List with Checkboxes</title>
    <style>
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .entry {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <input type="text" id="searchInput" placeholder="Search...">
        <div id="entryList">
            <div class="entry">
                <input type="checkbox" id="entry1" name="entries" value="Entry 1">
                <label for="entry1">Entry 1</label>
            </div>
            <div class="entry">
                <input type="checkbox" id="entry2" name="entries" value="Entry 2">
                <label for="entry2">Entry 2</label>
            </div>
            <div class="entry">
                <input type="checkbox" id="entry3" name="entries" value="Entry 3">
                <label for="entry3">Entry 3</label>
            </div>
            <div class="entry">
                <input type="checkbox" id="entry4" name="entries" value="Entry 4">
                <label for="entry4">Entry 4</label>
            </div>
            <div class="entry">
                <input type="checkbox" id="entry5" name="entries" value="Entry 5">
                <label for="entry5">Entry 5</label>
            </div>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const entryList = document.getElementById('entryList');

        searchInput.addEventListener('input', () => {
            const searchValue = searchInput.value.toLowerCase();
            const entries = entryList.getElementsByClassName('entry');

            for (let entry of entries) {
                const labelText = entry.textContent.toLowerCase();
                if (labelText.includes(searchValue)) {
                    entry.style.display = '';
                } else {
                    entry.style.display = 'none';
                }
            }
        });
    </script>
</body>
</html>
