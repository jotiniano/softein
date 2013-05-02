<?php

/**
 * Description of User
 *
 * @author James Otiniano
 */
class App_Model_DetaExperiencia extends App_Db_Table_Abstract {

    protected $_name = 'detaexperiencia';

    const TABLA_EMPRESA = 'detaexperiencia';
    
    private function _guardar($datos, $condicion = NULL) {
       
        $id = 0;
        if (!empty($datos['idDetalleExperiencia'])) {
            $id = (int) $datos['idDetalleExperiencia'];
        }
        unset($datos['idDetalleExperiencia']);
        $datos = array_intersect_key($datos, array_flip($this->_getCols()));

        if ($id > 0) {
            $condicion = '';
            if (!empty($condicion)) {
              echo  $condicion = ' AND ' . $condicion;
              exit;
            }

           $cantidad = $this->update($datos, 'idDetalleExperiencia = ' . $id . $condicion);
         
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            
            $id = $this->insert($datos);
        }
        return $id;
    }

    public function actualizarDatos($datos) {
        return $this->_guardar($datos);
    }
   
    public function listarUsuario()
    {
        $query = $this->getAdapter()
                ->select()->from(array('e' => $this->_name))
                ->where('u.estado = ?', App_Model_Usuario::ESTADO_ACTIVO)
                ->where('u.tipoUsuario = ?', App_Model_Usuario::TIPO_ADMIN)
                ->limit(50);

        return $this->getAdapter()->fetchAll($query);
    }
    
    public function getEmpresaPorId($id, $tipo = NULL) 
    {
        $query = $this->getAdapter()->select()
                ->from($this->_name)
                ->where('idEmpresa = ?', $id);
        if ($tipo)
            $query->where ('idTipoUsuario = ?', $tipo);
        
        return $this->getAdapter()->fetchRow($query);
    }    
    
    public function getValidarEmpresaLogin($dato,$tipo) 
    {
         $query = $this->getAdapter()->select()
                ->from($this->_name);
              
            if ($tipo == 1){ //email
                $query->where ('email = ?', $dato);
                 
            }
            if ($tipo == 2){ //estado usuario
                $query->where ('idEmpresa = ?', $dato);
            }
            
     
        return $this->getAdapter()->fetchRow($query);
    }
    
    public function eliminarDetalle($id){
        $where = $this->getAdapter()->quoteInto('idConvocatoriaExperiencia =?', $id);
        $this->delete($where);
    }
    
    public function getExperienciaEmpresa($idEmpresa, $idConvocatoria) 
    {
        $query = $this->getAdapter()->select()
                ->from(array('ce' => App_Model_ConvocatoriaEmpresa::TABLA_EMPRESA))
                ->joinInner(array('d' => $this->_name), 
                        'ce.idConvocatoriaExperiencia = d.idConvocatoriaExperiencia')
                ->joinInner(array('e' => App_Model_Experiencia::TABLA_DETALLEEMPRESA), 
                        'd.idExperiencia = e.idDetalleEmpresa')
                ->joinInner(array('p' => App_Model_Pais::TABLA_EMPRESA), 
                        'e.servicioPais = p.idPais')
                ->where('ce.idEmpresa = ?', $idEmpresa)
                ->where('ce.idConvocatoria = ?', $idConvocatoria)
                ;
        return $this->getAdapter()->fetchAll($query);
    }   
}