import './bootstrap';

import swal from 'sweetalert';

import Inputmask from "inputmask";

import excluir from './funcoes/excluir';
window.excluir = excluir;

import adicionarMascara from './funcoes/adicionar-mascara';
window.adicionarMascara = adicionarMascara;

import * as pesquisa from './preencherCep';
window.pesquisaCep = pesquisa.pesquisaCep;
window.buscarMunicipios = pesquisa.buscarMunicipios;