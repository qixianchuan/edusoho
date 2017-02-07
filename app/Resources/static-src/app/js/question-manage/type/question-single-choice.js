import QuestionChoice from './question-choice';
import ReactDOM from 'react-dom';
import React from 'react';
import QuestionOptions from 'app/common/component/question-options';

class SingleChoice extends QuestionChoice {
  initOptions() {

    console.log(this.imageUploadUrl);
    console.log(this.dataSource);
    console.log(this.dataAnswer);
    console.log(this.imageDownloadUrl);
    ReactDOM.render( <QuestionOptions imageUploadUrl={this.imageUploadUrl} imageDownloadUrl={this.imageDownloadUrl} dataSource={this.dataSource} dataAnswer={this.dataAnswer}  isRadio={true}/>,
      document.getElementById('question-options')
    );
  }
}

export default SingleChoice;