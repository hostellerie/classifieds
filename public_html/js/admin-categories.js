document.addEventListener('DOMContentLoaded', function () {
    var parentSelect = document.getElementById('classifieds-parent-category');
    var positionSelect = document.getElementById('classifieds-category-position');

    if (!parentSelect || !positionSelect) {
        return;
    }

    function refreshPositionOptions() {
        var parentId = parseInt(parentSelect.value || '0', 10);
        var options = positionSelect.options;
        var selectedStillValid = false;

        for (var i = 0; i < options.length; i++) {
            var option = options[i];
            var optionParent = option.getAttribute('data-parent');

            if (!optionParent) {
                option.hidden = false;
                option.disabled = false;
            } else {
                var matchesParent = parseInt(optionParent, 10) === parentId;
                option.hidden = !matchesParent;
                option.disabled = !matchesParent;
            }

            if (option.selected && !option.disabled) {
                selectedStillValid = true;
            }
        }

        if (!selectedStillValid) {
            positionSelect.value = 'last';
        }
    }

    parentSelect.addEventListener('change', refreshPositionOptions);
    refreshPositionOptions();
});
