@foreach($convenio as $convenios)
<!-- Modal Para Adicionar Novo Convênio -->

<div wire:ignore.self class="modal fade" id="apagarConvenio{{$convenios->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">

		<!-- Conteúdo do modal-->
		<div class="modal-content">

			<!-- Cabeçalho do modal -->
			<div class="modal-header">
				<h4 class="modal-title">Desativar um Convênio</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Corpo do modal -->
			<div class="modal-body">

				<form class="form-horizontal" action="cadastroConvenios/{{$convenios->id}}/delete" method="post">

					{{method_field('PUT')}}

					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<p class="text-center">Tem certeza de que deseja desativar o convenio {{$convenios->nome_fantasia}} ?</p>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>Fechar</button>
				<button type="submit" name="apagarConvenio" id="apagarConvenio" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Confirmar</a>
					</form>
			</div>

		</div>
	</div>
</div>


@endforeach