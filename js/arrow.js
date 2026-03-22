<script>
const track = document.querySelector('.review-wrapper');
const nextButton = document.getElementById('carouselnext');
const backButton = document.getElementById('carouselback');


nextButton.addEventListener('click',()=> {
	track.scrollBy({ left: 320, behavior: 'smooth' });
});

backButton.addEventListener('click',() => {
	track.scrollBy({left: -320, behavior: 'smooth' });
});
</script>