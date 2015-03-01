<div id="catchwayModal" class="modal fade" tabindex="-1" role="dialog"
     aria-hidden="true">
  <div class="modal-dialog  modal-sm">
    <div id="catchwayModalFind" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="catchwayModalLabelFind">
          Ваш город:
           <strong id="catchwayCityName"> Санкт-Петербург</strong>
          <br/>мы угадали?
        </h5>
      </div>
      <div class="modal-body">
        <div id="catchwayModalButtons">
          <button type="button" id="catchwayModalButtonNo" class="btn btn-danger" >Нет</button>
          <button type="button" id="catchwayModalButtonYes" class="btn btn-success">Да</button>
        </div>
      </div>
    </div>
    <div style="display: none" id="catchwayModalChoice" class="modal-content">
      <div class="modal-header">
        <h5 id="catchwayModalLabelChoice">
          Выберете ваш город:
        </h5>
      </div>
      <div class="modal-body">
        <div id="catchwayModalCities">
          <ul>
            [[+output]]
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>