(function() {
    /**
     * Open share link popup
     */
    function openPopup(event) {
        let width, height;
    	const id = this.id,
              url = this.href;

		const excludedIds = ['cher-link-email', 'cher-link-link'];
		if (excludedIds.includes(id)) {
			return;
		}

        switch (id) {

            case 'cher-link-twitter':
                width = 500;
                height = 442;
            break;

            case 'cher-link-linkedin':
                width = 500;
                height = 516;
            break;

            case 'cher-link-googleplus':
                width = 400;
                height = 600;
            break;

            case 'cher-link-pinterest':
                width = 752;
                height = 620;
            break;

            default:
                width = 550;
                height = 330;
        }

        event.preventDefault();
        window.open(url, id, 'status=no,height=' + height + ',width=' + width + ',resizable=yes,toolbar=no,menubar=no,scrollbars=no,location=no,directories=no');
    }

    function onDocumentReady() {
        // Click event for share links
        const links = document.querySelectorAll('.cher-link');
		if (!links) {
			return;
		}

		links.forEach(l => l.addEventListener('click', openPopup));
    }

    document.addEventListener('DOMContentLoaded', function() {
        onDocumentReady();
    });

})();