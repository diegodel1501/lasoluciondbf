

<div class="modal fade" id="modal-delete-{{$p->idproducto}}">
 <form action="{{ route('producto.destroy', $p->idproducto) }}" method="POST">
  {{ method_field('DELETE') }}
  {{ csrf_field() }}
  <div class="modal-dialog">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">
      <span aria-hidden>x</span>
     </button>
     <h4 class="modal-title">Eliminar Producto</h4>
    </div>
    <div class="modal-body">
     <p>
      Confirme si desea Eliminar <strong>{{ $p->nombre }}</strong>
     </p>
    </div>
    <div class="modal-footer">
     <button type="button" class="btn btn-default" data-dismiss="modal">
      Cerrar
     </button>
     <button type="submit" class="btn btn-primary">Confirmar</button>
    </div>
   </div>
  </div>
 </form>
</div>


