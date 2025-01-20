$(document).ready(function() {
    // 1) Load JSON data
    $.getJSON("./assets/data/subjects.json", function(data) {
      let subjects = data.subjects;
  
      // 2) Generate Tabs & Content
      subjects.forEach((subject, index) => {
        // ----- A) Create the Tab button -----
        let isActiveTab = (index === 0) ? "active" : "";
        let ariaSelected = (index === 0) ? "true" : "false";
  
        let tabButton = `
          <li class="nav-item" role="presentation">
            <button
              class="nav-link ${isActiveTab}"
              id="${subject.id}-tab"
              data-bs-toggle="tab"
              data-bs-target="#${subject.id}"
              type="button"
              role="tab"
              aria-controls="${subject.id}"
              aria-selected="${ariaSelected}"
            >
              ${subject.title}
            </button>
          </li>
        `;
        $("#subjectTabs").append(tabButton);
  
        // ----- B) Create the Tab Pane container -----
        let isActivePane = (index === 0) ? "show active" : "";
        let tabPane = `
          <div
            class="tab-pane fade ${isActivePane} p-3"
            id="${subject.id}"
            role="tabpanel"
            aria-labelledby="${subject.id}-tab"
          >
          </div>
        `;
        $("#subjectTabsContent").append(tabPane);
  
        // Build the HTML content inside the tab pane
  
        // (1) Overview Card
        let overviewHTML = `
          <div class="card mb-4">
            <div class="card-body">
              <h4 class="card-title">${subject.title}</h4>
              <p><strong>Credits:</strong> ${subject.credits}</p>
              <p><strong>Teaching Scheme:</strong> ${subject.teachingScheme}</p>
              <p><strong>Prerequisites:</strong> ${subject.coursePrerequisites}</p>
              <p><strong>Objectives:</strong></p>
              <ul>
                ${subject.courseObjectives
                  .map(obj => `<li>${obj}</li>`)
                  .join("")}
              </ul>
              <p><strong>Relevance:</strong> ${subject.courseRelevance}</p>
            </div>
          </div>
        `;
  
        // (2) Units Accordion
        let accordionId = `${subject.id}-accordion`;
  
        let unitsHTML = `
          <div class="accordion mb-4" id="${accordionId}">
            ${subject.units
              .map((unit, i) => {
                let unitId = `${accordionId}-unit${i}`;
                // Show either the unit's title or a default
                let unitTitle = unit.title ? unit.title : `Unit ${i + 1}`;
                return `
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="${unitId}-header">
                      <button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#${unitId}-body"
                        aria-expanded="false"
                        aria-controls="${unitId}-body">
                        ${unitTitle}
                      </button>
                    </h2>
                    <div
                      id="${unitId}-body"
                      class="accordion-collapse collapse"
                      aria-labelledby="${unitId}-header"
                      data-bs-parent="#${accordionId}">
                      <div class="accordion-body">
                        <p>${unit.content}</p>
                        ${
                          unit.fullDetails
                            ? `<p>${unit.fullDetails}</p>`
                            : ""
                        }
                      </div>
                    </div>
                  </div>
                `;
              })
              .join("")}
          </div>
        `;
  
        // (3) Helper to create a "List" card
        function createListCard(title, items) {
          if (!items || items.length === 0) {
            return "";
          }
          return `
            <div class="card mb-4">
              <div class="card-body">
                <h5 class="card-title">${title}</h5>
                <ul>
                  ${items.map(item => `<li>${item}</li>`).join("")}
                </ul>
              </div>
            </div>
          `;
        }
  
        // (4) Additional Cards
        let tutorialsCard = createListCard("List of Tutorials", subject.tutorials);
        let practicalsCard = createListCard("List of Practicals", subject.practicals);
        let projectsCard = createListCard("List of Course Projects", subject.courseProjects);
        let discussionCard = createListCard("List of Group Discussion Areas", subject.groupDiscussionAreas);
        let homeAssignmentCard = createListCard("List of Home Assignment Areas", subject.homeAssignmentAreas);
  
        // ----- C) Append everything into the tab pane -----
        let finalContent = `
          ${overviewHTML}
          ${unitsHTML}
          ${tutorialsCard}
          ${practicalsCard}
          ${projectsCard}
          ${discussionCard}
          ${homeAssignmentCard}
        `;
  
        $(`#${subject.id}`).append(finalContent);
      });
    });
  });
  