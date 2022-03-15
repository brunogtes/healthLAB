@foreach($convenio as $convenios)
<!-- Modal Para Adicionar Novo Convênio -->

<div wire:ignore.self class="modal fade" id="editConvenio{{$convenios->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">

		<!-- Conteúdo do modal-->
		<div class="modal-content">

			<!-- Cabeçalho do modal -->
			<div class="modal-header">
				<h4 class="modal-title">Visualizar Convênio</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Corpo do modal -->
			<div class="modal-body">

				<div clas="span10 offset1">
					<div class="card">

						<div class="card-body">
							<form class="form-horizontal" action="cadastroConvenios/{{$convenios->id}}/update" method="post">

								{{method_field('PUT')}}

								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<div class="row form-group">
									<div class="col-sm-2">
										<label class="control-label" style="position:relative; top:7px;">Razão Social:</label>
									</div>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="razao_social" id="razao_social" value="{{$convenios->nome_fantasia}}">
									</div>
								</div>

								<div class="row form-group">
									<div class="col-sm-2">
										<label class="control-label" style="position:relative; top:7px;">Nome Fantasia:</label>
									</div>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="nome_fantasia" id="nome_fantasia" value="{{$convenios->nome_fantasia}}">
									</div>
								</div>


								<div class="row form-group">
									<div class="col-sm-2">
										<label class="control-label" style="position:relative; top:7px;">CNPJ:</label>
									</div>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="cnpj" id="cnpj" mask="00.000.000/0000-00" value="{{$convenios->cnpj}}">
									</div>
								</div>


								<div class="row form-group">
									<div class="col-sm-2">
										<label class="control-label" style="position:relative; top:7px;">Situação:</label>
									</div>
									<div class="col-sm-10">
										<select class="form-control" name="situacao" id="situacao">
											<option value="{{$convenios->situacao}}">{{$convenios->situacao}}</option>
											<option value="ATIVO">Ativo</option>
											<option value="INATIVO">Inativo</option>
										</select>
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
				<button type="submit" name="editConvenio" id="editConvenio" class="btn btn-success"><span class="glyphicon glyphicon-check"></span> Atualizar</a>


			</div>

			</form>

		</div>
	</div>
</div>

@endforeach