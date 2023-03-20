$(document).ready(function() {
  $("#addSkill").click(function() {
      var html = `
          <div class="form-row mt-2">
              <div class="form-group col-md-6">
                  <label for="Compétences">Nom du compétences</label>
                  <input type="text" class="form-control" name="skill[]" placeholder="">
              </div>

              <div class="form-group col-md-6">
                  <label for="NiveauCompetences">Niveau</label>
                  <select class="form-control selecttt" name="skill_level[]">
                      <option value="">Sélectionner un niveau</option>
                      <option value="Débutant">Débutant</option>
                      <option value="Intermédiaire">Intermédiaire</option>
                      <option value="Expert">Expert</option>
                  </select>
              </div>
          </div>
      `;
      $("#skills").append(html);
  });
});