import React from "react";
import ReactQuill from "react-quill";
import EditorToolbar, { modules, formats } from "./EditorToolbar";
import "react-quill/dist/quill.snow.css";

export const Editor = ({ form, register, control, Controller, className, disabled }) => {
  const [state, setState] = React.useState({ value: null });
  const handleChange = value => {
    setState({ value });
  };

  return (
    <div className="text-editor">
      <EditorToolbar />
      <Controller
        name={form.name}
        control={control}
        render={({field: {onChange, value}}) => (
            <ReactQuill
                theme="snow"
                value={value}
                onChange={onChange}
                placeholder={form.placeholder}
                modules={modules}
                formats={formats}
                className={`h-[400px] ${className}`}
                readOnly={disabled}
            />
        )}
      />
    </div>
  );
};

export default Editor;
