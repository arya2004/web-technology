
    $(document).ready(function () {
      
        $.getJSON('./assets/data/projects.json', function (projects) {
            projects.forEach(project => {
                
                let projectDetails = project.details.map(detail => `<li>${detail}</li>`).join('');
               
                let githubButton = project.github
                    ? `<a href="${project.github}" target="_blank" class="btn btn-primary">View on GitHub</a>`
                    : '';
            
                let projectHTML = `
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">${project.title}</h5>
                                <p class="text-muted">${project.description}</p>
                                <ul>${projectDetails}</ul>
                                ${githubButton}
                            </div>
                        </div>
                    </div>
                `;
              
                $('#project-container').append(projectHTML);
            });
        }).fail(function () {
            console.error("Could not load projects.json");
        });
    });
