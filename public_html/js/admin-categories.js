document.addEventListener('DOMContentLoaded', function () {
    var parentSelect = document.getElementById('classifieds-parent-category');
    var rootOrderField = document.getElementById('classifieds-root-order-field');
    var childPositionField = document.getElementById('classifieds-child-position-field');
    var positionSelect = document.getElementById('classifieds-child-position');

    if (!parentSelect || !rootOrderField || !childPositionField || !positionSelect) {
        return;
    }

    function refreshPositionOptions() {
        var parentId = parseInt(parentSelect.value || '0', 10);
        var isChild = parentId > 0;

        rootOrderField.hidden = isChild;
        childPositionField.hidden = !isChild;

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

        if (isChild && !selectedStillValid) {
            positionSelect.value = 'last';
        }
    }

    parentSelect.addEventListener('change', refreshPositionOptions);
    refreshPositionOptions();
});
