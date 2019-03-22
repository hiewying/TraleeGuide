//test if javascript works
//alert(1);

const activities = document.getElementById('activities');

if(activities){
    activities.addEventListener('click', (e) => {
        
        if(e.target.className === 'btn btn-danger delete-article'){
            
            if(confirm('Are you sure?')){
                const id = e.target.getAttribute('data-id');
                
                // alert(id);
                fetch(`/activity/delete/${id}`, {method: 'DELETE'}).then(res => window.location.reload());
            }
        }

    });
}
