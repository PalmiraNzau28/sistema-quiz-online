import { Injectable } from '@angular/core';
import jsPDF from 'jspdf';
import { saveAs } from 'file-saver';

@Injectable({ providedIn: 'root' })
export class ExportService {
  exportToCSV(quizTitle: string, userAnswers: any[], score: number, totalQuestions: number) {
    const headers = ['Pergunta', 'Resposta Selecionada', 'Correta?', 'Pontuação'];
    const rows = userAnswers.map(a => [a.questionText, a.selectedAnswer, a.isCorrect ? 'Sim' : 'Não', a.isCorrect ? '1' : '0']);
    
    let csvContent = headers.join(',') + '\n';
    rows.forEach(row => {
      csvContent += row.map(cell => `"${cell}"`).join(',') + '\n';
    });
    
    // Adicionar resumo
    csvContent += `\n"RESUMO","${quizTitle}","Pontuação: ${score}/${totalQuestions}","${new Date().toLocaleString()}"`;
    
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    saveAs(blob, `quiz_${quizTitle}_${Date.now()}.csv`);
  }

  exportToPDF(quizTitle: string, userAnswers: any[], score: number, totalQuestions: number) {
    const doc = new jsPDF();
    let y = 20;
    
    // Título
    doc.setFontSize(18);
    doc.text(`Resultado: ${quizTitle}`, 20, y);
    y += 15;
    
    // Resumo
    doc.setFontSize(12);
    doc.text(`Data: ${new Date().toLocaleString()}`, 20, y);
    y += 10;
    doc.text(`Pontuação: ${score}/${totalQuestions} (${Math.round(score/totalQuestions*100)}%)`, 20, y);
    y += 20;
    
    // Cabeçalhos da tabela
    doc.setFontSize(10);
    doc.text('Pergunta', 20, y);
    doc.text('Resposta', 80, y);
    doc.text('Resultado', 140, y);
    y += 10;
    
    // Linhas
    userAnswers.forEach((a, i) => {
      if (y > 270) {
        doc.addPage();
        y = 20;
      }
      doc.text(`${i+1}. ${a.questionText.substring(0, 30)}`, 20, y);
      doc.text(a.selectedAnswer.substring(0, 30), 80, y);
      doc.text(a.isCorrect ? '✓ Correto' : '✗ Errado', 140, y);
      y += 8;
    });
    
    doc.save(`quiz_${quizTitle}_${Date.now()}.pdf`);
  }
}