import './bootstrap';

import swal from 'sweetalert';

import Inputmask from "inputmask";

import excluir from './funcoes/excluir';
window.excluir = excluir;

import inativar from './funcoes/inativar';
window.inativar = inativar;

import ativar from './funcoes/ativar';
window.ativar = ativar;

import * as mask  from './funcoes/adicionar-mascara';
window.mascaraPorAtributo = mask.mascaraPorAtributo;
window.mascaraTelefoneCelular = mask.mascaraTelefoneCelular;
window.mascaraCpfCnpj = mask.mascaraCpfCnpj;

import * as adicionarRemoverCampos from './funcoes/adicionar-remover-campos';
window.duplicarCampos = adicionarRemoverCampos.duplicarCampos;
window.removerCampo = adicionarRemoverCampos.removerCampo;

import * as pesquisa from './preencherCep';
window.pesquisaCep = pesquisa.pesquisaCep;
window.buscarMunicipios = pesquisa.buscarMunicipios;