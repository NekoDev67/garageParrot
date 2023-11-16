// Script redirection click
document.getElementById('venteLink').addEventListener('click', function() 
{
    window.location.href = this.getAttribute('href');
});