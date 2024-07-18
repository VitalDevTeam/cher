(function() {
    function onDocumentReady() {
		const els = document.querySelectorAll('.click-copy');

		if (!els) {
			return;
		}
	
		els.forEach(e => e.addEventListener('click', clickCopy));
    }

	function clickCopy(e) {
		const actor = e.target;
		let target;
		if (actor.classList.contains('click-copy')) {
			target = actor;
		} else {
			target = actor.closest('.click-copy');
			if (!target) {
				return;
			}
		}

		e.preventDefault();
	
		navigator.clipboard.writeText(target.href).then(() => {
			openSuccessBalloon(target);
		});
	}

	function openSuccessBalloon(target) {
		const balloon = document.createElement('div');
		balloon.innerHTML = 'Copied Link!';
		balloon.classList.add('click-copy-balloon');
		target.appendChild(balloon);
	}

    document.addEventListener('DOMContentLoaded', function() {
        onDocumentReady();
    });

})();