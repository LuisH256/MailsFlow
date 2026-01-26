// Lógica JavaScript para gerar os campos dinamicamente
function gerarFormularioDePreenchimento(conteudoTemplate) {
    const container = document.getElementById('container-campos');
    container.innerHTML = '';

    // 1. Encontrar campos de Seleção [[Opção1/Opção2]]
    const regexSelect = /\[\[(.*?)\]\]/g;
    let matchSelect;
    while ((matchSelect = regexSelect.exec(conteudoTemplate)) !== null) {
        const opcoes = matchSelect[1].split('/');
        const labelText = "Selecione uma opção:"; // Você pode personalizar isso
        
        let selectHtml = `<div class="mb-4">
            <label class="block text-sm font-bold text-slate-700 mb-1">Destinatário:</label>
            <select class="w-full p-4 bg-white border border-slate-200 rounded-2xl outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Selecione</option>`;
        
        opcoes.forEach(opt => {
            selectHtml += `<option value="${opt}">${opt}</option>`;
        });
        
        selectHtml += `</select></div>`;
        container.innerHTML += selectHtml;
    }

    // 2. Encontrar campos de Texto {{campo}}
    const regexInput = /{{(.*?)}}/g;
    let matchInput;
    while ((matchInput = regexInput.exec(conteudoTemplate)) !== null) {
        const campoNome = matchInput[1];
        container.innerHTML += `
            <div class="mb-4">
                <label class="block text-sm font-bold text-slate-700 mb-1">${campoNome.toUpperCase()}:</label>
                <input type="text" placeholder="Digite ${campoNome}..." 
                       class="w-full p-4 bg-white border border-slate-200 rounded-2xl outline-none focus:ring-2 focus:ring-blue-500">
            </div>`;
    }
}